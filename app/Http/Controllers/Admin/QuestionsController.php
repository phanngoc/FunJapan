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
        $inputs = $request->input('question');
        $messages = QuestionService::validate($inputs);
        $checkMessage = false;
        $checkUpdate = false;
        foreach ($messages as $key => $message) {
            if (!empty($message)) {
                $checkMessage = true;
            }
        }

        if ($checkMessage) {
            return response()->json([
                'message' => $messages,
            ]);
        }

        foreach ($inputs as $key => $input) {
            if (isset($input['id'])) {
                $question = Question::find($input['id']);
                if ($question) {
                    $checkUpdate = true;
                    break;
                }
            }
        }

        if ($checkUpdate) {
            if (QuestionService::update($inputs)) {
                Session::flash('message', trans('admin/survey.update_success'));
            } else {
                Session::flash('error', trans('admin/survey.update_error'));
            }
        } else {
            if (QuestionService::store($inputs)) {
                Session::flash('message', trans('admin/survey.create_success'));
            } else {
                Session::flash('error', trans('admin/survey.create_error'));
            }
        }
    }

    public function edit(Survey $survey, $questionId)
    {
        $this->viewData['survey'] = $survey;
        $this->viewData['question'] = Question::find($questionId);

        return view('admin.questions.edit', $this->viewData);
    }

    public function destroy(Survey $survey, $questionId)
    {
        if (QuestionService::destroy($questionId)) {
            Session::flash('message', trans('admin/survey.delete_success'));
        } else {
            Session::flash('error', trans('admin/survey.delete_error'));
        }
    }

    public function updateOrder(Request $request)
    {
        $inputs = $request->all();
        if (QuestionService::updateOrder($inputs)) {
            return redirect()->back()->with(['message' => trans('admin/question.order_success')]);
        }

        return redirect()->back()->withErrors(['message' => trans('admin/question.order_errors')]);
    }
}
