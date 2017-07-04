<?php

namespace App\Services\Admin;

use App\Models\EditorChoice;
use Validator;
use Illuminate\Validation\Rule;

class EditorChoiceService
{
    public static function validate($inputs, $editorChoice = null)
    {
        $validationRules = [
            'url' => 'required|unique:editor_choices,link',
        ];
        if ($editorChoice) {
            $validationRules = [
                'url' => [
                    'required',
                    Rule::unique('editor_choices', 'link')->ignore($editorChoice->id),
                ],
            ];
        }

        return Validator::make($inputs, $validationRules)
            ->setAttributeNames(trans('admin/editor_choices'));
    }

    public static function create($data)
    {
        return EditorChoice::create($data);
    }

    public static function update($data, $editorChoice)
    {
        return $editorChoice->update($data);
    }
}
