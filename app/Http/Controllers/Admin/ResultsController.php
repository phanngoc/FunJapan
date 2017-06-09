<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Services\Admin\ResultService;
use App\Models\Result;
use Session;

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

        $checkUpdate = false;
        foreach ($inputs['result'] as $key => $input) {
            if (isset($input['id'])) {
                $result = Result::find($input['id']);
                if ($result) {
                    $checkUpdate = true;
                    break;
                }
            }
        }
        if ($checkUpdate) {
            if (ResultService::update($inputs)) {
                Session::flash('message', trans('admin/survey.update_success'));
            } else {
                Session::flash('error', trans('admin/survey.update_error'));
            }
        } else {
            if (ResultService::create($inputs)) {
                Session::flash('message', trans('admin/survey.create_success'));
            } else {
                Session::flash('error', trans('admin/survey.create_error'));
            }
        }
    }
}
