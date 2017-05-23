<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\SurveyService;
use App\Services\Admin\LocaleService;
use App\Models\Survey;

class SurveysController extends Controller
{
    public function index(Request $request)
    {
        $localeId = $request->input('locale_id') ?? array_first(array_keys(LocaleService::getAllLocales()));
        $this->viewData['locales'] = LocaleService::getAllLocales();
        $this->viewData['localeId'] = $localeId;
        $this->viewData['surveys'] = SurveyService::getAllViaLocale($localeId);

        return view('admin.surveys.index', $this->viewData);
    }

    public function show($id)
    {
        $survey = Survey::find($id);

        if (!$survey) {
            return redirect()->action('Admin\SurveysController@index')
                ->withErrors(['errors' => trans('admin/survey.survey_not_exist')]);
        }

        $this->viewData['survey'] = $survey;

        return view('admin.surveys.detail', $this->viewData);
    }

    public function create()
    {
        $this->viewData['locales'] = LocaleService::getAllLocales();

        return view('admin.surveys.create', $this->viewData);
    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $inputs['point'] = $inputs['point'] ?? 0;
        $validator = SurveyService::validate($inputs);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        $survey = SurveyService::store($inputs);
        if ($survey) {
            return redirect()->action('Admin\SurveysController@show', [$survey->id])
                ->with(['message' => trans('admin/survey.create_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/survey.create_error')]);
    }

    public function edit($id)
    {
        $survey = Survey::find($id);
        $this->viewData['locales'] = LocaleService::getAllLocales();
        if (!$survey) {
            return redirect()->action('Admin\SurveysController@index')
                ->withErrors(['errors' => trans('admin/survey.survey_not_exist')]);
        }

        $this->viewData['survey'] = $survey;

        return view('admin.surveys.edit', $this->viewData);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        $validator = SurveyService::validate($inputs);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($inputs);
        }

        if (SurveyService::update($inputs, $id)) {
            return redirect()->action('Admin\SurveysController@index')
                ->with(['message' => trans('admin/survey.update_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/survey.update_error')]);
    }
}
