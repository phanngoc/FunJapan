<?php

namespace App\Services\Admin;

use App\Models\BannerSetting;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Validator;

class BannerSettingService extends BaseService
{
    public static function validateStore($input)
    {
        $mimes = config('images.validate.banner.mimes');
        $maxSize = config('images.validate.banner.max_size');

        $rules = [
            'photo' => 'required|mimes:' . $mimes . '|max:' . $maxSize,
            'from' => 'required|date',
            'to' => 'required|date',
            'locale_id' => 'required',
            'order' => 'required',
            'article_locale_id' => 'required|unique:banner_settings',
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
        $query = BannerSetting::where('locale_id', $localeId)
            ->orderBy('order', 'asc');

        if ($isFront) {
            $toDay = Carbon::now()->toDateString();
            $query = $query->where('article_locale_id', '!=', 0)
                ->where('from', '<=', $toDay)
                ->where('to', '>=', $toDay);

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

    public static function delete($bannerId)
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
    }
}
