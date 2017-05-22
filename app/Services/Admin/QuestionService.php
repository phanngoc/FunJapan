<?php

namespace App\Services\Admin;

use App\Models\Question;
use DB;
use Validator;

class QuestionService extends BaseService
{
    public static function validate($inputs)
    {
        $validationRules = [
            'title' => 'required',
        ];

        return Validator::make($inputs, $validationRules);
    }

    public static function destroy($questionId)
    {
        $question = Question::find($questionId);
        if ($question) {
            return $question->delete();
        } else {
            return false;
        }
    }

    public static function update($inputs, $id)
    {
        $question = Question::find($id);
        if ($question) {
            return $question->update([
                'question_type' => $inputs['question_type'],
                'title' => $inputs['title'],
                'option_name' => $inputs['option_name'] ?? null,
            ]);
        } else {
            return false;
        }
    }
}
