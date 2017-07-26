<?php

namespace App\Services\Admin;

use App\Models\BannerSetting;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Validator;

class BannerSettingService extends BaseService
{
    public static function validateStore($input)
    {
        $mimes = config('images.validate.banner.mimes');
        $maxSize = config('images.validate.banner.max_size');

        $rules = [
            'locale_id' => 'required',
            'order' => 'required',
            'article_locale_id' => 'required|unique:banner_settings',
            'photo' => 'required|mimes:' . $mimes . '|max:' . $maxSize,
        ];

        $messages = [
            'article_locale_id.required' => trans('admin/banner.validate.required.article_locale_id'),
        ];

        return Validator::make($input, $rules, $messages)->messages()->toArray();
    }

    public static function create($input)
    {
        $banner = BannerSetting::where('locale_id', $input['locale_id'])
            ->where('order', $input['order'])
            ->first();

        try {
            if (!$banner) {
                $banner = BannerSetting::create(['locale_id' => $input['locale_id']]);
            }

            if (isset($input['photo']) && $input['photo'] instanceof UploadedFile) {
                $photoUploadPath = config('images.paths.banner') . '/' . $banner->id;
                $input['photo'] = ImageService::uploadFile($input['photo'], 'banner', $photoUploadPath, true);
            }

            $banner->update($input);

            return $banner;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function getBannerViaLocale($localeId, $isFront = true)
    {
        $query = BannerSetting::select('banner_settings.*')
            ->where('banner_settings.locale_id', $localeId)
            ->orderBy('order', 'asc');

        if ($isFront) {
            $query = $query->where('article_locale_id', '!=', 0)
                ->leftJoin('article_locales', 'banner_settings.article_locale_id', 'article_locales.id')
                ->where('article_locales.published_at', '<=', Carbon::now(config('app.admin_timezone')))
                ->where('article_locales.end_published_at', '>=', Carbon::now(config('app.admin_timezone')))
                ->where('article_locales.status', config('article.status.published'));

            $banner = $query->limit(config('banner.limit'))->get();

            if ($banner->count() < config('banner.limit')) {
                return null;
            }

            return $banner;
        }

        return $query->limit(config('banner.limit'))->get();
    }

    public static function getAllBanner($locales)
    {
        $result = [];

        foreach ($locales as $localeId => $localeName) {
            $result[$localeId] = self::getBannerViaLocale($localeId, false);
        }

        return $result;
    }

    /*public static function delete($bannerId)
    {
        $banner = BannerSetting::find($bannerId);

        try {
            if ($banner) {
                $photoUploadPath = config('images.paths.banner') . '/' . $banner->id;
                if (ImageService::delete($photoUploadPath)) {
                    $banner->delete();
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }*/

    public static function validateUpdate($input, $id)
    {
        $mimes = config('images.validate.banner.mimes');
        $maxSize = config('images.validate.banner.max_size');

        $rules = [
            'article_locale_id' => [
                'required',
                Rule::unique('banner_settings')->ignore($id),
            ],
        ];

        if ($input['is_uploaded_photo']) {
            $rules['photo'] = 'required|mimes:' . $mimes . '|max:' . $maxSize;
        }

        $messages = [
            'article_locale_id.required' => trans('admin/banner.validate.required.article_locale_id'),
        ];

        return Validator::make($input, $rules, $messages)->messages()->toArray();
    }

    public static function update($input, $bannerId)
    {
        $banner = BannerSetting::find($bannerId);

        if ($banner) {
            if (isset($input['photo']) && $input['photo'] instanceof UploadedFile) {
                $photoUploadPath = config('images.paths.banner') . '/' . $banner->id;
                $input['photo'] = ImageService::uploadFile($input['photo'], 'banner', $photoUploadPath, true);
            } else {
                unset($input['photo']);
            }

            return $banner->update($input);
        }

        return false;
    }

    public static function checkActiveUrl($value)
    {
        if (!is_string($value)) {
            return false;
        }

        $url = parse_url($value, PHP_URL_HOST);

        if ($url && $url == parse_url(config('app.url'), PHP_URL_HOST)) {
            try {
                return count(dns_get_record($url, DNS_A | DNS_AAAA)) > 0;
            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
    }

    public static function processUrlSearch($value)
    {
        $url = parse_url($value, PHP_URL_PATH);

        $regex = '/\/(' . implode(config('app.locales'), '|') . ')\/(articles)\/([^\/]*)(\/|\?)*/';

        preg_match($regex, $url, $matches);

        return isset($matches[3]) ? $matches[3] : $value;
    }
}
