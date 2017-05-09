<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Question;
use App\Services\Admin\QuestionService;
use Session;

class QuestionsController extends Controller
{
    public function create(Survey $survey)
    {
        $this->viewData['survey'] = $survey;

        return view('admin.questions.create', $this->viewData);
    }

    public function store(Request $request, Survey $survey)
    {
        $inputs = $request->all();
        $validator = QuestionService::validate($inputs);
        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->first('title'));
        }

        if ($survey->questions()->create($inputs)) {
            Session::flash('message', trans('admin/survey.create_success'));
        } else {
            Session::flash('error', trans('admin/survey.create_error'));
        }
    }

    public function edit(Survey $survey, $questionId)
    {
        $this->viewData['survey'] = $survey;
        $this->viewData['question'] = Question::find($questionId);

        return view('admin.questions.edit', $this->viewData);
    }

    public function update(Request $request, Survey $survey, $questionId)
    {
        $inputs = $request->all();
        $validator = QuestionService::validate($inputs);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInputs($inputs);
        }

        if (QuestionService::update($inputs, $questionId)) {
            return redirect()->action('Admin\SurveysController@show', [$survey->id])
                ->with(['message' => trans('admin/survey.update_success')]);
        }

        return redirect()->back()->withErrors(['error' => trans('admin/survey.update_error')]);
    }

    public function destroy(Survey $survey, $questionId)
    {
        if (QuestionService::destroy($questionId)) {
            Session::flash('message', trans('admin/survey.delete_success'));
        } else {
            Session::flash('error', trans('admin/survey.delete_error'));
        }
    }
}
