<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\ArticleService;
use App\Services\Admin\BannerSettingService;
use App\Services\Admin\LocaleService;
use Illuminate\Http\Request;
use Gate;

class BannerSettingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission', 'banner.change'), 403, 'Unauthorized action.');

        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['bannerSettingLocales'] = BannerSettingService::getAllBanner($this->viewData['locales']);

        return view('admin.banner.index', $this->viewData);
    }

    public function getArticle(Request $request)
    {
        $condition = $request->only(['key_word', 'locale_id', 'page', 'banner_id']);

        return response()->json(ArticleService::getListForBanner($condition));
    }

    public function update($localeId, Request $request)
    {
        abort_if(Gate::denies('permission', 'banner.change'), 403, 'Unauthorized action.');

        if (!auth()->check()) {
            return response()->json(['message' => trans('admin/banner.validate.unauthorized')], 401);
        }

        $input = $request->only(['banner']);

        $validate = BannerSettingService::validateUpdate($input['banner']);

        if (count($validate)) {
            return response()->json(['message' => $validate], 400);
        }

        $banner = BannerSettingService::update($input['banner'], $localeId);

        if ($banner) {
            return response()->json(['data' => $banner]);
        }

        return response()->json(
            [
                'message' => ['article_locale_id' => [trans('admin/banner.validate.article_banner')]],
            ],
            400
        );
    }

    public function delete($localeId)
    {
        abort_if(Gate::denies('permission', 'banner.change'), 403, 'Unauthorized action.');

        if (!auth()->check()) {
            return response()->json(['message' => trans('admin/banner.validate.unauthorized')], 401);
        }

        $banner = BannerSettingService::delete($localeId);

        if ($banner) {
            return response()->json(['success' => true]);
        }

        return response()->json(
            [
                'message' => 'Something went wrong',
            ],
            400
        );
    }
}
