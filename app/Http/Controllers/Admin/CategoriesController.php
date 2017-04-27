<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\CategoryService;
use App\Services\Admin\LocaleService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Auth;
use Session;

class CategoriesController extends Controller
{
    public function index()
    {
        $this->viewData['categories'] = CategoryService::listCategory();

        return view('admin.category.index', $this->viewData);
    }

    public function create()
    {
        $this->viewData['locales'] = CategoryService::getLocale();

        return view('admin.category.create', $this->viewData);
    }

    public function show($id)
    {
        $category = CategoryService::find($id);
        if ($category) {
            $this->viewData['category'] = $category;

            return view('admin.category.detail', $this->viewData);
        }

        return redirect()->action('Admin\CategoriesController@index')
                ->withErrors(['errors' => trans('admin/category.category_not_exist')]);
    }

    public function edit($id)
    {
        $category = CategoryService::find($id);
        if ($category) {
            $this->viewData['category'] = $category;

            return view('admin.category.edit', $this->viewData);
        }

        return redirect()->action('Admin\CategoriesController@index')
                ->withErrors(['errors' => trans('admin/category.category_not_exist')]);
    }

    public function update(Request $request)
    {
        $inputs = $request->all();
        $validator = CategoryService::validate($inputs, 'update');
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        if (CategoryService::update($inputs)) {
            return redirect()->action('Admin\CategoriesController@show', $inputs['id'])
                ->with(['message' => trans('admin/category.update_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/category.update_error')]);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = CategoryService::validate($inputs);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        $id = CategoryService::create($inputs);
        if ($id) {
            return redirect()->action('Admin\CategoriesController@show', $id)
                ->with(['message' => trans('admin/category.create_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/category.create_error')]);
    }

    public function destroy($id)
    {
        $response = [
            'status' => false,
            'message' => trans('admin/category.delete_error'),
        ];
        if (CategoryService::delete($id)) {
            $response = [
                'status' => true,
                'message' => trans('admin/category.delete_success'),
            ];
            Session::flash('message', trans('admin/category.delete_success'));
        } else {
            Session::flash('error', trans('admin/category.delete_error'));
        }

        return response()->json($response);
    }

    public function getCategories(Request $request)
    {
        $query = $request->input('q');
        $dataReturn = [];
        $dataReturn['items'] = CategoryService::getCategoriesByQuery($query);

        return $dataReturn;
    }
}
