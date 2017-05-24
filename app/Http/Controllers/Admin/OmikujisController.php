<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\OmikujiService;
use App\Services\Admin\LocaleService;
use App\Models\Omikuji;
use Carbon\Carbon;

class OmikujisController extends Controller
{
    public function index()
    {
        $this->viewData['locales'] = json_encode(LocaleService::getLocaleSort());

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
            $this->viewData['omikujiItems'] = $omikuji->omikujiItems;

            return view('admin.omikuji.detail', $this->viewData);
        }

        return redirect()->action('Admin\OmikujisController@index')
                ->withErrors(['errors' => trans('admin/omikuji.omikuji_not_exist')]);
    }

    public function create()
    {
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
        $inputs = $request->all();
        if (OmikujiService::checkRecord($inputs['omikuji_id'])) {
            if (OmikujiService::deleteOmikujiItem($omikujiItemId)) {
                return redirect()->action('Admin\OmikujisController@edit', $inputs['omikuji_id'])
                    ->with(['message' => trans('admin/omikuji.delete_success')]);
            }
        } else {
            return redirect()->action('Admin\OmikujisController@edit', $request->all()['omikuji_id'])
                ->with(['error' => trans('admin/omikuji.check_record')]);
        }

        return redirect()->action('Admin\OmikujisController@index')
                    ->withErrors(['errors' => trans('admin/omikuji.delete_error')]);
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
