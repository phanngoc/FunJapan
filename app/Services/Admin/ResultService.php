<?php

namespace App\Services\Admin;

use App\Models\Result;
use DB;
use Validator;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;

class ResultService extends BaseService
{
    public static function validate($inputs)
    {
        $message = [];
        $validationRules = [
            'required_point_from' => 'integer|min:0|max:999999999',
            'required_point_to' => 'integer|min:0|max:999999999',
            'title' => 'required|min:10|max:255',
        ];

        foreach ($inputs['result'] as $key => $input) {
            $message[$key] = Validator::make($input, $validationRules)->setAttributeNames([
                'required_point_from' => 'Score From',
                'required_point_to' => 'Score To',
                'title' => 'Title',
            ])->messages()->toArray();
            if (is_numeric($input['required_point_from'])
                && is_numeric($input['required_point_to'])
                && $input['required_point_from'] > $input['required_point_to']) {
                $message[$key]['required_point_from'][] = 'Must be smaller';
            }
        }

        return $message;
    }

    public static function create($inputs)
    {
        if ($inputs) {
            DB::beginTransaction();
            try {
                foreach ($inputs['result'] as $key => $input) {
                    if (isset($input['id'])) {
                        $result = Result::find($input['id']);
                        if ($result) {
                            $result->update([
                                'survey_id' => $inputs['survey_id'],
                                'required_point_from' => $input['required_point_from'],
                                'required_point_to' => $input['required_point_to'],
                                'title' => $input['title'],
                                'description' => $input['description'],
                                'bottom_text' => $input['bottom_text'],
                            ]);

                            if (isset($input['photo'])) {
                                $photoUploadPath = config('images.paths.result_survey') . '/' . $result->id;
                                $photo = ImageService::uploadFile(
                                    $input['photo'],
                                    'result_survey',
                                    $photoUploadPath,
                                    true
                                );

                                if (isset($photo)) {
                                    $result->update([
                                        'photo' => $photo,
                                    ]);
                                }
                            }
                        }
                    } else {
                        $result = Result::create([
                            'survey_id' => $inputs['survey_id'],
                            'required_point_from' => $input['required_point_from'],
                            'required_point_to' => $input['required_point_to'],
                            'title' => $input['title'],
                            'description' => $input['description'] ?? null,
                            'bottom_text' => $input['bottom_text'] ?? null,
                        ]);

                        if ($result) {
                            if (isset($input['photo'])) {
                                $photoUploadPath = config('images.paths.result_survey') . '/' . $result->id;
                                $photo = ImageService::uploadFile(
                                    $input['photo'],
                                    'result_survey',
                                    $photoUploadPath,
                                    true
                                );
                                if (isset($photo)) {
                                    $result->update([
                                        'photo' => $photo,
                                    ]);
                                }
                            }
                        }
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
}
