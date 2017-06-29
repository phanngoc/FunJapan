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
        $check = false;
        $validationRules = [
            'title' => 'required|min:10|max:255',
        ];

        foreach ($inputs as $key => $input) {
            $message[$key] = Validator::make($input, $validationRules)->setAttributeNames([
                'title' => trans('admin/question.question'),
            ])->messages()->toArray();

            if ($input['question_type'] == config('question.type_value.checkbox') ||
                $input['question_type'] == config('question.type_value.radio')) {
                foreach ($input['option_name'] as $keyOption => $option) {
                    if ($option != null) {
                        $check = true;
                        if (strlen($option) > config('question.character.max')) {
                            $message[$key]['option_name'][$keyOption] = trans('admin/question.error_option.max', [
                                'value' => config('question.character.max'),
                            ]);
                        }
                    }
                }

                if (!$check) {
                    $message[$key]['option_name'][0] = trans('admin/question.error_option.at_least');
                }
            }

            if (isset($input['score'])) {
                foreach ($input['score'] as $keyScore => $score) {
                    if (isset($score)) {
                        if (!preg_match('/^[0-9]+$/', $score)) {
                            $message[$key]['score'][$keyScore] = trans('admin/question.error_score.integer');
                        } else {
                            if ($score != 0) {
                                $score = ltrim($score, '0');
                            }

                            if ($score > config('question.number.max')) {
                                $message[$key]['score'][$keyScore] = trans('admin/question.error_score.max', [
                                    'value' => config('question.number.max'),
                                ]);
                            } elseif ($score < config('question.number.min')) {
                                $message[$key]['score'][$keyScore] = trans('admin/question.error_score.min', [
                                    'value' => config('question.number.min'),
                                ]);
                            } elseif ($input['option_name'][$keyScore] == null) {
                                $message[$key]['option_name'][$keyScore] = trans('admin/question.error_option.enter');
                            }
                        }
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
                    if ($input['question_type'] == config('question.type_value.checkbox') ||
                        $input['question_type'] == config('question.type_value.radio')) {
                        foreach ($input['option_name'] as $keyOption => $valueOption) {
                            if ($valueOption == null && $input['score'][$keyOption] == null) {
                                unset($input['option_name'][$keyOption]);
                                unset($input['score'][$keyOption]);
                            }

                            if (isset($input['score'][$keyOption])) {
                                $input['score'][$keyOption] = ltrim($input['score'][$keyOption], '0');
                            }
                        }
                    }
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

    public static function update($inputs)
    {
        foreach ($inputs as $key => $input) {
            $question = Question::find($input['id']);
            if ($input['question_type'] == config('question.type_value.checkbox') ||
                $input['question_type'] == config('question.type_value.radio')) {
                foreach ($input['option_name'] as $keyOption => $valueOption) {
                    if ($valueOption == null && $input['score'][$keyOption] == null) {
                        unset($input['option_name'][$keyOption]);
                        unset($input['score'][$keyOption]);
                    }

                    if (isset($input['score'][$keyOption])) {
                        $input['score'][$keyOption] = ltrim($input['score'][$keyOption], '0');
                    }
                }
            }

            if ($question) {
                return $question->update([
                    'question_type' => $input['question_type'],
                    'title' => $input['title'],
                    'option_name' => $input['option_name'] ?? null,
                    'score' => $input['score'] ?? null,
                    'other_option' => $input['other_option'] ?? 0,
                ]);
            } else {
                return false;
            }
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
