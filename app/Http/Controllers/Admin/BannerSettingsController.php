<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\ArticleService;
use App\Services\Admin\BannerSettingService;
use App\Services\Admin\LocaleService;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Input;

class BannerSettingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission', 'banner.change'), 403, 'Unauthorized action.');

        $currentLocale = Input::get('locale_id');
        $isSuccess = Input::get('isSuccess');
        $isDeleted = Input::get('isDeleted');
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['currentLocale'] = array_key_exists($currentLocale, $this->viewData['locales']) ? $currentLocale : key($this->viewData['locales']) ;
        $this->viewData['bannerSettingLocales'] = BannerSettingService::getAllBanner($this->viewData['locales']);

        if ($isSuccess) {
            session()->flash('message', trans('admin/banner.label_update_success'));
        }

        if ($isDeleted) {
            session()->flash('message', trans('admin/banner.label_delete_success'));
        }

        return view('admin.banner.index', $this->viewData);
    }

    public function getArticle(Request $request)
    {
        $condition = $request->only(['key_word', 'locale_id', 'page', 'banner_id']);

        return response()->json(ArticleService::getListForBanner($condition));
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('permission', 'banner.change'), 403, 'Unauthorized action.');

        if (!auth()->check()) {
            return response()->json(['message' => trans('admin/banner.validate.unauthorized')], 401);
        }

        $input = $request->only([
            'article_locale_id',
            'article_title',
            'from',
            'to',
            'photo',
            'photo_base',
            'locale_id',
            'order',
        ]);

        $validate = BannerSettingService::validateStore($input);

        if (count($validate)) {
            return response()->json(['message' => $validate], 400);
        }

        $banner = BannerSettingService::create($input);

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

    public function delete($bannerId)
    {
        abort_if(Gate::denies('permission', 'banner.change'), 403, 'Unauthorized action.');

        if (!auth()->check()) {
            return response()->json(['message' => trans('admin/banner.validate.unauthorized')], 401);
        }

        $banner = BannerSettingService::delete($bannerId);

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
