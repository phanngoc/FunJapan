<?php

namespace App\Services\Admin;

use App\Models\Question;
use DB;
use Validator;

class QuestionService extends BaseService
{
    public static function validate($inputs)
    {
        $message = [];
        foreach ($inputs as $key => $input) {
            if ($input['question_type'] == config('question.type_value.checkbox') ||
                $input['question_type'] == config('question.type_value.radio')) {
                foreach ($input['option_name'] as $keyOption => $option) {
                    if ($keyOption == 0 && $option == null) {
                        $message[$key]['option_name'][$keyOption] = trans('admin/question.error_option.required');
                    }
                }
            }
            if ($input['title'] == null) {
                $message[$key]['title'] = trans('admin/question.error_title.required');
            } elseif (strlen($input['title']) > config('question.max_title')) {
                $message[$key]['title'] = trans('admin/question.error_title.max');
            }

            if (isset($input['score'])) {
                foreach ($input['score'] as $keyScore => $score) {
                    if (isset($score) && !is_numeric($score)) {
                        $message[$key]['score'][$keyScore] = trans('admin/question.error_score.integer');
                    }
                }
            }
        }

        return $message;
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

    public static function store($inputs)
    {
        if ($inputs) {
            DB::beginTransaction();
            try {
                foreach ($inputs as $key => $input) {
                    $question = Question::firstOrCreate([
                        'survey_id' => $input['survey_id'],
                        'question_type' => $input['question_type'],
                        'title' => $input['title'],
                        'option_name' => $input['option_name'] ?? null,
                        'score' => $input['score'] ?? null,
                        'other_option' => $input['other_option'] ?? 0,
                    ]);

                    if ($question) {
                        $question->update([
                            'order' => QuestionService::getLastId($input['survey_id']) + 1,
                        ]);
                    }
                }
                DB::commit();

                return true;
            } catch (\Exception $e) {
                DB::rollback();

                return false;
            }
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
                'score' => $inputs['score'] ?? null,
                'other_option' => $inputs['other_option'] ?? 0,
            ]);
        } else {
            return false;
        }
    }

    public static function updateOrder($inputs)
    {
        $listIds = $inputs['order'];
        $placeholders = implode(',', array_fill(0, count($listIds), '?'));
        $questions = Question::whereIn('id', $listIds)
            ->orderByRaw("field (id, {$placeholders})", $listIds)
            ->get();
        DB::beginTransaction();
        try {
            foreach ($questions as $key => $question) {
                $question->order = $key + 1;
                $question->save();
            }
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    public static function getLastId($surveyId)
    {
        $question = Question::whereSurveyId($surveyId)
            ->orderBy('order', 'desc')
            ->first();

        return $question->order;
    }
}
