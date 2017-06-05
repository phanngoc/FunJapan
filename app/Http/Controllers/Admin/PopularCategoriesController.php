<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PopularCategory;
use App\Services\Admin\LocaleService;
use App\Services\Admin\CategoryService;
use App\Services\Admin\PopularCategoryService;

class PopularCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $localeId = $request->input('locale') ?? array_first(array_keys(LocaleService::getAllLocales()));
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['localeId'] = $localeId;

        return view('admin.popular_category.index', $this->viewData);
    }

    public function getListCategories(Request $request)
    {
        $params = $request->input();
        $draw = $params['draw'];
        $seriesData = PopularCategoryService::list($params);
        $seriesData['draw'] = (int)$draw;

        return $seriesData;
    }

    public function create()
    {
        $this->viewData['locales'] = LocaleService::getAllLocales();

        return view('admin.popular_category.create', $this->viewData);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        if (isset($inputs['link'])) {
            $inputs['oldLink'] = CategoryService::getCategory($inputs['link']);
        }

        $validator = PopularCategoryService::validate($inputs);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }
        if (PopularCategoryService::create($inputs)) {
            return redirect()->action('Admin\PopularCategoriesController@index')
                ->with(['message' => trans('admin/popular_category.create_success')]);
        }

        return redirect()->back()->withErrors(['error' => trans('admin/popular_category.create_error')]);
    }

    public function edit(PopularCategory $popularCategory)
    {
        $this->viewData['popularCategory'] = $popularCategory;
        $this->viewData['oldLink'] = CategoryService::getCategory($popularCategory->link);

        return view('admin.popular_category.edit', $this->viewData);
    }

    public function update(Request $request, PopularCategory $popularCategory)
    {
        $inputs = $request->all();
        if (isset($inputs['link'])) {
            $inputs['oldLink'] = CategoryService::getCategory($inputs['link']);
        }

        $validator = PopularCategoryService::validate($inputs, $popularCategory);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }
        if (PopularCategoryService::update($inputs, $popularCategory)) {
            return redirect()->action('Admin\PopularCategoriesController@index')
                ->with(['message' => trans('admin/popular_category.update_success')]);
        }

        return redirect()->back()->withErrors(['error' => trans('admin/popular_category.update_error')]);
    }

    public function getSuggest(Request $request)
    {
        $inputs = $request->all();
        $dataReturn['items'] = PopularCategoryService::suggestCategories($inputs);

        return $dataReturn;
    }

    public function delete(PopularCategory $popularCategory)
    {
        if (PopularCategoryService::delete($popularCategory)) {
            return redirect()->action('Admin\PopularCategoriesController@index')
                ->with(['message' => trans('admin/popular_category.delete_success')]);
        }

        return redirect()->back()->withErrors(['error' => trans('admin/popular_category.delete_error')]);
    }
}
