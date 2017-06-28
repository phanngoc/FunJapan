<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\OmikujiService;
use App\Services\Admin\LocaleService;
use App\Models\Omikuji;
use Carbon\Carbon;
use Auth;

class OmikujisController extends Controller
{
    public function index(Request $request)
    {
        $this->viewData['locales'] = LocaleService::getLocaleSort();
        $localeId = $request->input('locale_id') ?? array_first(array_keys(LocaleService::getLocaleSort()));
        $this->viewData['localeId'] = $localeId;

        return view('admin.omikuji.index', $this->viewData);
    }

    public function getListOmikujis(Request $request)
    {
        $params = $request->all();
        $draw = $params['draw'];
        $tagsData = OmikujiService::list($params);
        $tagsData['draw'] = (int)$draw;

        return $tagsData;
    }

    public function show($id)
    {
        $omikuji = OmikujiService::findOmikuji($id);
        if ($omikuji) {
            $this->viewData['omikuji'] = $omikuji;
            $omikujiItems = $omikuji->omikujiItems;
            $sum = collect($omikujiItems)->sum('rate_weight');
            $count = count($omikujiItems);
            $i = 1;
            $percent = 0;
            foreach ($omikujiItems as $omikujiItem) {
                if ($i <$count) {
                    $round = round(($omikujiItem->rate_weight/$sum)*100, 2);
                    $percent = $percent + $round;
                    $omikujiItem->rate_weight = $omikujiItem->rate_weight . ' (' . $round . '%)';
                }
                $i++;
            }
            if ($count > 0) {
                $omikujiItems[$count -1]->rate_weight = $omikujiItems[$count -1]->rate_weight
                    . ' (' . (100 - $percent) . '%)';
            }
            $this->viewData['omikujiItems'] = $omikuji->omikujiItems;

            return view('admin.omikuji.detail', $this->viewData);
        }

        return redirect()->action('Admin\OmikujisController@index')
                ->withErrors(['errors' => trans('admin/omikuji.omikuji_not_exist')]);
    }

    public function create()
    {
        $user = Auth::user();
        if ($user) {
            $this->viewData['locale_select'] = $user->locale_id;
        }
        $this->viewData['locales'] = LocaleService::getLocaleSort();

        return view('admin.omikuji.create', $this->viewData);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = OmikujiService::validate($inputs, 'create');
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        $id = OmikujiService::create($inputs);
        if ($id) {
            return redirect()->action('Admin\OmikujisController@show', $id)
                ->with(['message' => trans('admin/omikuji.create_success')]);
        }
        return redirect()->back()->withErrors(['errors' => trans('admin/omikuji.create_error')]);
    }

    public function edit($id)
    {
        $omikuji = OmikujiService::findOmikuji($id);

        if ($omikuji) {
            $this->viewData['omikuji'] = $omikuji;
            $this->viewData['omikujiItems'] = $omikuji->omikujiItems;
            $this->viewData['locales'] = LocaleService::getLocaleSort();
            return view('admin.omikuji.edit', $this->viewData);
        }

        return redirect()->action('Admin\OmikujisController@index')
                ->withErrors(['errors' => trans('admin/omikuji.omikuji_not_exist')]);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        $validator = OmikujiService::validate($inputs, 'update');
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        if (OmikujiService::update($inputs, $id)) {
            return redirect()->action('Admin\OmikujisController@show', $id)
                ->with(['message' => trans('admin/omikuji.update_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/omikuji.update_error')]);
    }

    public function destroy(Request $request, $omikujiItemId)
    {
        $response = [
            'status' => false,
            'message' => trans('admin/omikuji.delete_error'),
        ];
        $inputs = $request->all();
        if (OmikujiService::checkRecord($inputs['omikuji_id'])) {
            if (OmikujiService::deleteOmikujiItem($omikujiItemId)) {
                $response = [
                    'status' => true,
                    'message' => trans('admin/omikuji.delete_success'),
                ];

                return $response;
            }
        } else {
            $response = [
                'status' => false,
                'message' => trans('admin/omikuji.message_record_count'),
            ];

            return $response;
        }

        return $response;
    }

    public function destroyOmikuji($id)
    {
        if (OmikujiService::deleteOmikuji($id)) {
            return redirect()->action('Admin\OmikujisController@index')
                ->with(['message' => trans('admin/omikuji.delete_success')]);
        }

        return redirect()->action('Admin\OmikujisController@index')
                    ->withErrors(['errors' => trans('admin/omikuji.delete_error')]);
    }
}
