<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\LocaleService;
use App\Services\Admin\PopularSeriesService;
use App\Models\Category;
use App\Models\ArticleTag;
use App\Models\ArticleLocale;
use App\Models\Tag;
use App\Models\PopularSeries;
use App\Services\Admin\CategoryService;
use App\Services\Admin\TagService;

class PopularSeriesController extends Controller
{
    public function index(Request $request)
    {
        $localeId = $request->input('locale') ?? array_first(array_keys(LocaleService::getAllLocales()));
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['localeId'] = $localeId;

        return view('admin.popular_series.index', $this->viewData);
    }

    public function getListSeries(Request $request)
    {
        $params = $request->input();
        $draw = $params['draw'];
        $seriesData = PopularSeriesService::list($params);
        $seriesData['draw'] = (int)$draw;

        return $seriesData;
    }

    public function create()
    {
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['type'] = config('popular_series.type');

        return view('admin.popular_series.create', $this->viewData);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        if (isset($inputs['link']) && $inputs['type'] == strtolower(config('popular_series.type.tag'))) {
            $inputs['oldLink'] = TagService::getTag($inputs['link']);
        }

        if (isset($inputs['link']) && $inputs['type'] == strtolower(config('popular_series.type.category'))) {
            $inputs['oldLink'] = CategoryService::getCategory($inputs['link']);
        }

        $validator = PopularSeriesService::validate($inputs);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }
        if (PopularSeriesService::create($inputs)) {
            return redirect()->action('Admin\PopularSeriesController@index')
                ->with(['message' => trans('admin/popular_series.create_success')]);
        }

        return redirect()->back()->withErrors(['error' => trans('admin/popular_series.create_error')]);
    }

    public function edit(PopularSeries $popularSeries)
    {
        $this->viewData['type'] = config('popular_series.type');
        $this->viewData['popularSeries'] = $popularSeries;
        if ($popularSeries->type == strtolower(config('popular_series.type.tag'))) {
            $this->viewData['oldLink'] = TagService::getTag($popularSeries->link);
        } else {
            $this->viewData['oldLink'] = CategoryService::getCategory($popularSeries->link);
        }

        return view('admin.popular_series.edit', $this->viewData);
    }

    public function update(Request $request, PopularSeries $popularSeries)
    {
        $inputs = $request->all();
        if (isset($inputs['link']) && $inputs['type'] == strtolower(config('popular_series.type.tag'))) {
            $inputs['oldLink'] = TagService::getTag($inputs['link']);
        }

        if (isset($inputs['link']) && $inputs['type'] == strtolower(config('popular_series.type.category'))) {
            $inputs['oldLink'] = CategoryService::getCategory($inputs['link']);
        }

        $validator = PopularSeriesService::validate($inputs, $popularSeries);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        if (PopularSeriesService::update($inputs, $popularSeries)) {
            return redirect()->action('Admin\PopularSeriesController@index')
                ->with(['message' => trans('admin/popular_series.update_success')]);
        }

        return redirect()->back()->withErrors(['error' => trans('admin/popular_series.update_error')]);
    }

    public function getSuggest(Request $request)
    {
        $inputs = $request->all();
        $dataReturn['items'] = PopularSeriesService::suggestCategoryOrTags($inputs);

        return $dataReturn;
    }

    public function delete(PopularSeries $popularSeries)
    {
        if (PopularSeriesService::delete($popularSeries)) {
            return redirect()->action('Admin\PopularSeriesController@index')
                ->with(['message' => trans('admin/popular_series.delete_success')]);
        }

        return redirect()->back()->withErrors(['error' => trans('admin/popular_series.delete_error')]);
    }
}
