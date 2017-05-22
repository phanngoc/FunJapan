<?php

namespace App\Services\Admin;

use App\Models\Survey;
use DB;
use Validator;

class SurveyService extends BaseService
{
    public static function validate($inputs)
    {
        $validationRules = [
            'title' => 'required|min:10|max:255',
            'type' => 'required|in:' . implode(',', array_keys(config('survey.type'))),
            'point' => 'numeric',
        ];

        return Validator::make($inputs, $validationRules);
    }

    public static function getAll()
    {
        return Survey::all();
    }

    public static function store($inputs)
    {
        return Survey::create([
            'title' => $inputs['title'],
            'description' => $inputs['description'],
            'type' => $inputs['type'],
            'point' => $inputs['point'],
            'user_id' => auth()->user()->id,
            'locale_id' => $inputs['locale'],
            'multiple_join' => $inputs['multiple_join'],
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
}
