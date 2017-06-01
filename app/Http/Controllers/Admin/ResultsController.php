<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Services\Admin\ResultService;
use App\Models\Result;

class ResultsController extends Controller
{
    public function index(Survey $survey)
    {
        $this->viewData['survey'] = $survey;
        $this->viewData['results'] = Result::whereSurveyId($survey->id)->get();

        return view('admin.results.edit', $this->viewData);
    }

    public function create(Survey $survey)
    {
        $this->viewData['survey'] = $survey;
        $this->viewData['id'] = 0;

        return view('admin.results.create', $this->viewData);
    }

    public function store(Request $request, Survey $survey)
    {
        $inputs = $request->all();
        $validator = ResultService::validate($inputs);
        if (count(array_filter($validator))) {
            return response()->json(['message' => $validator]);
        }

        if (ResultService::create($inputs)) {
            return redirect()->action('Admin\SurveysController@show', $survey->id)
                ->with(['message' => trans('admin/article.create_success')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/article.create_error')]);
    }
}
