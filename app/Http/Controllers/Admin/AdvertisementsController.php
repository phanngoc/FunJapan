<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\LocaleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\AdvertisementService;
use Gate;

class AdvertisementsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission', 'advertisement.change'), 403, 'Unauthorized action.');

        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['advertisements'] = AdvertisementService::getAll();

        return view('admin.advertisement.index', $this->viewData);
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('permission', 'advertisement.change'), 403, 'Unauthorized action.');

        $inputs = $request->only(['advertisement']);

        $validate = AdvertisementService::validate($inputs);

        if (count($validate)) {
            return response()->json(['message' => $validate], 400);
        }

        $isSuccess = AdvertisementService::update($inputs['advertisement']);

        if ($isSuccess) {
            return response()->json(['data' => $isSuccess]);
        }

        return response()->json(
            [
                'message' => ['article_locale_id' => [trans('admin/banner.validate.article_banner')]],
            ],
            400
        );
    }

    public function change($advertisementId, Request $request)
    {
        abort_if(Gate::denies('permission', 'advertisement.change'), 403, 'Unauthorized action.');

        $input = $request->only([
            'start_date',
            'end_date',
            'is_active',
        ]);

        if (!$input['is_active']) {
            $validate = AdvertisementService::validateChange($input);

            if (count($validate)) {
                return response()->json(['message' => $validate], 400);
            }
        }

        $isSuccess = AdvertisementService::change($advertisementId, $input);

        if ($isSuccess) {
            return response()->json(['data' => $isSuccess]);
        }

        return response()->json(
            [
                'message' => ['article_locale_id' => [trans('admin/banner.validate.article_banner')]],
            ],
            400
        );
    }
}
