<?php

namespace App\Services\Admin;

use App\Models\ArticleLocale;
use App\Models\BannerSetting;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Validator;

class BannerSettingService extends BaseService
{
    public static function validateUpdate($inputs)
    {
        $result = [];
        $listArticle = [];
        $mimes = config('images.validate.banner.mimes');
        $maxSize = config('images.validate.banner.max_size');

        $rules = [
            'article_locale_id' => 'required',
            'photo' => 'mimes:' . $mimes . '|max:' . $maxSize,
        ];

        $messages = [
            'article_locale_id.required' => trans('admin/banner.validate.required.article_locale_id'),
        ];

        foreach ($inputs as $key => $input) {
            $validate = Validator::make($input, $rules, $messages)->messages()->toArray();

            if ($input['article_locale_id'] && $duplicateKey = array_search($input['article_locale_id'], $listArticle)) {
                $validate['article_locale_id']['duplicate'] = trans('admin/banner.validate.duplicate');
                $result[$duplicateKey]['article_locale_id']['duplicate'] = trans('admin/banner.validate.duplicate');
            }

            if (!isset($input['is_uploaded_photo']) || !$input['is_uploaded_photo']) {
                $validate['photo'][] = trans('admin/banner.validate.required.photo');
            }

            $article = ArticleLocale::find($input['article_locale_id']);
            if ($article && !$article->is_show_able) {
                $result[$key]['article_locale_id'][] = trans('admin/banner.validate.not_show');
            }

            if (count($validate)) {
                $result[$key] = $validate;
            }

            $listArticle[$key] = $input['article_locale_id'];
        }


        return $result;
    }

    public static function update($inputs, $localeId)
    {
        $result = [];

        try {
            DB::beginTransaction();

            foreach ($inputs as $key => $input) {
                if (isset($input['id']) && $input['id']) {
                    $banner = BannerSetting::find($input['id']);
                } else {
                    $banner = BannerSetting::create(['locale_id' => $localeId]);
                }

                if (isset($input['photo']) && $input['photo'] instanceof UploadedFile) {
                    $photoUploadPath = config('images.paths.banner') . '/' . $banner->id;
                    $input['photo'] = ImageService::uploadFile($input['photo'], 'banner', $photoUploadPath, true);
                }

                $banner->update($input);
                $result[$key] = $banner;

                DB::commit();
            }

            return $result;
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            DB::rollBack();

            return false;
        }
    }

    public static function getBannerViaLocale($localeId)
    {
        return BannerSetting::where('locale_id', $localeId)
            ->limit(config('banner.limit'))
            ->orderBy('order')
            ->get();
    }

    public static function getAllBanner($locales)
    {
        $result = [];

        foreach ($locales as $localeId => $localeName) {
            $result[$localeId] = self::getBannerViaLocale($localeId);
        }

        return $result;
    }

    public static function delete($localeId)
    {
        $banners = BannerSetting::where('locale_id', $localeId)->get();

        try {
            foreach ($banners as $banner) {
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
