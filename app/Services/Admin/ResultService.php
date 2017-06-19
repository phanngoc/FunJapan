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
        foreach ($inputs['result'] as $key => $input) {
            $input['required_point_from'] = ltrim($input['required_point_from'], '0');
            $input['required_point_to'] = ltrim($input['required_point_to'], '0');
            $validationRules = [
                'title' => 'required|min:10|max:255',
            ];


            if (isset($input['required_point_from'])) {
                $validationRules['required_point_from'] = 'integer|min:0|max:999999999';
            }

            if (isset($input['required_point_to'])) {
                $validationRules['required_point_to'] =  'integer|min:0|max:999999999';
            }

            if (isset($input['bottom_text'])) {
                $validationRules['bottom_text'] = 'max:255';
            }

            $message[$key] = Validator::make($input, $validationRules)->setAttributeNames([
                'required_point_from' => trans('admin/result.score_from'),
                'required_point_to' => trans('admin/result.score_to'),
                'title' => trans('admin/result.title'),
            ])->messages()->toArray();

            if (!isset($input['required_point_from']) && !isset($input['required_point_to'])) {
                $message[$key]['required_point_from'] = trans('admin/result.required_or');
            }

            if (is_int($input['required_point_from'])
                && is_int($input['required_point_to'])
                && !isset($message[$key]['required_point_from'])
                && $input['required_point_from'] > $input['required_point_to']) {
                $message[$key]['required_point_from'] = trans('admin/result.not_greater_message');
            }

            $validationRules = [];
        }

        return $message;
    }

    public static function update($inputs)
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
                                'required_point_from' => $input['required_point_from'] ?? 0,
                                'required_point_to' => $input['required_point_to'] ?? 0,
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

    public static function create($inputs)
    {
        if ($inputs) {
            DB::beginTransaction();
            try {
                foreach ($inputs['result'] as $key => $input) {
                    $result = Result::firstOrCreate([
                        'survey_id' => $inputs['survey_id'],
                        'required_point_from' => $input['required_point_from'] ?? 0,
                        'required_point_to' => $input['required_point_to'] ?? 0,
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

                DB::commit();

                return true;
            } catch (\Exception $e) {
                DB::rollback();

                return false;
            }
        }
    }

    public static function destroy($id)
    {
        $result = Result::find($id);
        if ($result) {
            return $result->delete();
        } else {
            return false;
        }
    }
}
