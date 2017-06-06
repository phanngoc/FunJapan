<?php

namespace App\Services\Admin;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Result;
use DB;
use Validator;

class SurveyService extends BaseService
{
    public static function validate($inputs)
    {
        $validationRules = [
            'title' => 'required|min:10|max:255',
            'type' => 'required|in:' . implode(',', array_keys(config('survey.type'))),
            'point' => 'integer|min:0|max:999999999',
        ];

        return Validator::make($inputs, $validationRules)->setAttributeNames([
            'title' => trans('admin/survey.title'),
            'type' => trans('admin/survey.type'),
            'point' => trans('admin/survey.point'),
        ]);
    }

    public static function getAllViaLocale($localeId)
    {
        return Survey::whereLocaleId($localeId)->get();
    }

    public static function store($inputs)
    {
        return Survey::firstOrCreate([
            'title' => $inputs['title'],
            'description' => $inputs['description'],
            'type' => $inputs['type'],
            'point' => $inputs['point'],
            'user_id' => auth()->user()->id,
            'locale_id' => $inputs['locale'],
            'multiple_join' => $inputs['multiple_join'] ?? 0,
        ]);
    }

    public static function update($inputs, $id)
    {
        $survey = Survey::find($id);
        if ($survey) {
            return $survey->update([
                'title' => $inputs['title'],
                'description' => $inputs['description'],
                'type' => $inputs['type'],
                'point' => $inputs['point'],
                'user_id' => auth()->user()->id,
                'locale_id' => $inputs['locale'],
                'multiple_join' => $inputs['multiple_join'] ?? 0,
            ]);
        } else {
            return false;
        }
    }

    public static function destroy($id)
    {
        if ($id) {
            DB::beginTransaction();
            try {
                $questions = Question::whereSurveyId($id)->get();
                $results = Result::whereSurveyId($id)->get();
                foreach ($questions as $question) {
                    $question->delete();
                }

                foreach ($results as $result) {
                    $result->delete();
                }

                $survey = Survey::find($id);
                $survey->delete();
                DB::commit();

                return true;
            } catch (\Exception $e) {
                DB::rollback();

                return false;
            }
        }
    }
}
