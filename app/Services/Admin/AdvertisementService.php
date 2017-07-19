<?php

namespace App\Services\Admin;

use App\Models\Advertisement;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Validator;
use DB;
use Carbon\Carbon;
use Auth;

class AdvertisementService extends BaseService
{
    public static function getAll()
    {
        return Advertisement::orderBy('locale_id')->get();
    }

    public static function validate($inputs)
    {
        $result = [];
        $mimes = config('images.validate.advertisement.mimes');
        $maxSize = config('images.validate.advertisement.max_size');

        $rules = [
            'url' => 'required|active_url',
            'photo' => 'required|mimes:' . $mimes . '|max:' . $maxSize,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date|after:' . Carbon::today()->toDateString(),
        ];

        $messages = [
            'end_date.after' => trans('admin/advertisement.validate.after_end_date'),
        ];

        foreach ($inputs['advertisement'] as $key => $input) {
            if ($input['url']) {
                $validate = Validator::make($input, $rules, $messages)->messages()->toArray();

                if (count($validate)) {
                    $result[$key] = $validate;
                }
            }
        }

        return $result;
    }

    public static function update($inputs)
    {
        try {
            DB::beginTransaction();

            foreach ($inputs as $localeId => $input) {
                if ($input['url']) {
                    $input['is_not_publish'] = false;

                    $advertisement = Advertisement::where('locale_id', $localeId)->first();
                    if (!$advertisement) {
                        $advertisement = Advertisement::create(['locale_id' => $localeId]);
                    }

                    if (isset($input['photo']) && $input['photo'] instanceof UploadedFile) {
                        $photoUploadPath = config('images.paths.advertisement') . '/' . $advertisement->id;
                        $input['photo'] = ImageService::uploadFile($input['photo'], 'advertisement', $photoUploadPath, true);
                    }

                    $advertisement->update($input);
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    public static function validateChange($input)
    {
        $rules = [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];

        return Validator::make($input, $rules)->messages()->toArray();
    }

    public static function change($advertisementId, $input)
    {
        $advertisement = Advertisement::find($advertisementId);

        if ($advertisement) {
            if (!$input['is_active']) {
                $input['is_not_publish'] = false;
            } else {
                $input['is_not_publish'] = true;
            }

            return $advertisement->update($input);
        }

        return false;
    }
}