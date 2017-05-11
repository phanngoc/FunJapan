<?php

namespace App\Services\Admin;

use App\Models\Omikuji;
use App\Models\OmikujiItem;
use App\Services\ImageService;
use Illuminate\Support\Facades\Log;
use Validator;
use DB;
use Carbon\Carbon;

class OmikujiService extends BaseService
{
    public static function list($conditions)
    {
        $omikujis = Omikuji::all();
        $keyword = $conditions['search']['value'];
        $searchColumns = ['name', 'start_time', 'end_time'];
        $limit = $conditions['length'];
        $page = $conditions['start'] / $conditions['length'] + 1;
        $orderParams = $conditions['order'];
        $orderConditions['column'] = $conditions['columns'][$orderParams[0]['column']]['data'];
        $orderConditions['dir'] = $orderParams[0]['dir'];
        $query = Omikuji::query();

        $now = "DATE_FORMAT('" . Carbon::now() . "', '%Y-%m-%d %h:%i:%s') ";

        $query->selectRaw(" *, (
            CASE
                WHEN $now >= start_time && $now <= end_time THEN 'Running'
                WHEN $now >= start_time && $now > end_time Then 'Stopped'
                WHEN $now >= start_time &&  end_time is null Then 'Running'
                WHEN $now < start_time  THEN 'Stopped'
                ELSE ''
            END) AS status");
        $results = static::listItems($query, $keyword, $searchColumns, $orderConditions, $limit, $page);
        foreach ($results as $result) {
            $result['imageUrl'] = $result->imageUrls['normal'];
            $result['url'] = action('Admin\OmikujisController@destroyOmikuji', [$result->id]);
            $result['urlEdit'] = action('Admin\OmikujisController@edit', [$result->id]);
            $result['confirm'] = trans('admin/omikuji.delete_confirm', ['name' => $result['name']]);
        }
        return $returnData = [
            'recordsFiltered' => $results->total(),
            'data' => $results->items(),
        ];
    }

    public static function validate($inputs, $status = null)
    {
        $item = [];
        $rateWeight = [];
        $point = [];
        $itemImage = [];
        $sumRateWeight = '';
        $validationRules = [];
        $itemMimes = config('images.validate.omikuji_item_image.mimes');
        $itemSize = config('images.validate.omikuji_item_image.max_size');
        $messages = [
             'record_item.min' => trans('admin/omikuji.message_record_count'),
        ];

        $validationRules = [
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'recover_time' => 'required|integer|max:100',
            'description' => 'max:255',
            'item.*' => 'required|string|max:255',
            'rate_weight.*' => 'required|integer|max:1000|min:1',
            'point.*' => 'required|integer|min:1|max:10000',
            'record_item' => 'integer|min:1',
        ];

        if (isset($inputs['end_time'])) {
            $validationRules['end_time'] = 'date|after:start_time';
        }

        if ($status == 'update') {
            $validationRules['image'] = 'mimes:'. config('images.validate.omikuji_image.mimes') .'|max:' .
                 config('images.validate.omikuji_image.max_size');
        } elseif ($status == 'create') {
            $validationRules['image'] = 'required|mimes:'. config('images.validate.omikuji_image.mimes') .'|max:'
                . config('images.validate.omikuji_image.max_size');
        }

        foreach ($inputs['item'] as $key => $value) {
            //except row null
            if (isset($inputs['omikujiItem_id'][$key])) {
                $item[$key] = $value;
                $rateWeight[$key] = $inputs['rate_weight'][$key];
                $point[$key] = $inputs['point'][$key];
                $itemImage[$key] = $inputs['item_image'][$key] ?? null;
            } elseif (isset($value) || isset($inputs['rate_weight'][$key]) || isset($inputs['item_image'][$key])
                || isset($inputs['point'][$key])) {
                $item[$key] = $value;
                $rateWeight[$key] = $inputs['rate_weight'][$key];
                $point[$key] = $inputs['point'][$key];
                $itemImage[$key] = $inputs['item_image'][$key] ?? null;
                $validationRules['item_image.'.$key] = 'required|mimes:'. $itemMimes .'|max:' .$itemSize;
            }
        }
        $inputs['item'] = $item;
        $inputs['rate_weight'] = $rateWeight;
        $inputs['point'] = $point;
        $inputs['item_image'] = $itemImage;
        $inputs['record_item'] = count($inputs['item']);

        return Validator::make($inputs, $validationRules, $messages);
    }

    public static function findOmikuji($id)
    {
        return Omikuji::find($id);
    }

    public static function create($inputs)
    {
        DB::beginTransaction();
        try {
            $omikuji = new Omikuji();
            $omikuji->name = $inputs['name'];
            $omikuji->description = $inputs['description'];
            $omikuji->start_time = $inputs['start_time'];
            $omikuji->end_time = $inputs['end_time'];
            $omikuji->recover_time = $inputs['recover_time'];
            if (isset($inputs['locale_id'])) {
                $omikuji->locale_id = $inputs['locale_id'];
            }
            $omikuji->save();

            if ($omikuji->id) {
                if (isset($inputs['image'])) {
                    $imageUploadPath = config('images.paths.omikuji_image') . '/' . $omikuji->id;
                    $omikujiImage = ImageService::uploadFile($inputs['image'], 'omikuji_image', $imageUploadPath);
                    if ($omikujiImage) {
                        $omikuji->update([
                            'image' => $omikujiImage,
                        ]);
                    } else {
                        DB::rollback();
                        Log::error('uploaded image unsuccessfully!');

                        return false;
                    }
                }
                //insert omikuji item
                foreach ($inputs['item'] as $key => $item) {
                    if (isset($item) || isset($inputs['item_image'][$key]) || isset($inputs['rate_weight'][$key])
                        || isset($inputs['point'][$key])) {
                        $omikujiItem = new OmikujiItem();
                        $omikujiItem->name = $item;
                        $omikujiItem->rate_weight = $inputs['rate_weight'][$key];
                        $omikujiItem->point = $inputs['point'][$key];
                        $omikujiItem->omikuji_id = $omikuji->id;
                        $omikujiItem->save();
                        if (isset($inputs['item_image'][$key])) {
                            $imageItemUploadPath = config('images.paths.omikuji_item_image') . '/' . $omikujiItem->id;
                            $omikujiItemImage = ImageService::uploadFile(
                                $inputs['item_image'][$key],
                                'omikuji_item_image',
                                $imageItemUploadPath
                            );
                            if ($omikujiItemImage) {
                                $omikujiItem->update([
                                    'image' => $omikujiItemImage,
                                ]);
                            } else {
                                DB::rollback();
                                Log::error('uploaded image unsuccessfully!');

                                return false;
                            }
                        }
                    }
                }
            } else {
                DB::rollback();
                Log::error('created unsuccessfully!');

                return false;
            }
            DB::commit();

            return $omikuji->id;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }

    public static function update($inputs, $id)
    {
        DB::beginTransaction();
        try {
            $omikuji = Omikuji::find($id);
            if ($omikuji) {
                $image = '';
                if (isset($inputs['image'])) {
                    $omikujiImagePath = config('images.paths.omikuji_image') . '/' . $omikuji->id;
                    if ($omikuji->image) {
                        ImageService::delete($omikujiImagePath);
                    }
                    $image = ImageService::uploadFile($inputs['image'], 'omikuji_image', $omikujiImagePath);
                }
                $omikujiData =[
                        'name' => $inputs['name'],
                        'description' => $inputs['description'],
                        'start_time' => $inputs['start_time'],
                        'end_time' => $inputs['end_time'],
                        'recover_time' => $inputs['recover_time'],
                        'locale_id' => $inputs['locale_id'],
                    ];
                if ($image) {
                    $omikujiData['image'] = $image;
                    $result = $omikuji->update($omikujiData);
                }
                $result = $omikuji->update($omikujiData);

                if ($result) {
                    foreach ($inputs['item'] as $key => $item) {
                        //insert omikuji item
                        if (empty($inputs['omikujiItem_id'][$key])) {
                            if (isset($item) || isset($inputs['item_image'][$key])
                                || isset($inputs['rate_weight'][$key])
                                || isset($inputs['point'][$key])) {
                                $omikujiItem = new OmikujiItem();
                                $omikujiItem->name = $item;
                                $omikujiItem->rate_weight = $inputs['rate_weight'][$key];
                                $omikujiItem->point = $inputs['point'][$key];
                                $omikujiItem->omikuji_id = $id;
                                $omikujiItem->save();
                                if (isset($inputs['item_image'][$key])) {
                                    $imgItemPath = config('images.paths.omikuji_item_image') . '/' . $omikujiItem->id;
                                    $omikujiItemImage = ImageService::uploadFile(
                                        $inputs['item_image'][$key],
                                        'omikuji_item_image',
                                        $imgItemPath
                                    );
                                    if ($omikujiItemImage) {
                                        $omikujiItem->update([
                                            'image' => $omikujiItemImage,
                                        ]);
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        } else {
                            //update omikuji item
                            $omikujiItem = OmikujiItem::find($inputs['omikujiItem_id'][$key]);
                            if ($omikujiItem) {
                                if (isset($inputs['item_image'][$key])) {
                                    $omikujiItemImagePath = config('images.paths.omikuji_item_image') .
                                                                    '/' . $inputs['omikujiItem_id'][$key];
                                    if ($omikujiItem->image) {
                                        ImageService::delete($omikujiItemImagePath);
                                    }
                                    $imageItem = ImageService::uploadFile(
                                        $inputs['item_image'][$key],
                                        'omikuji_item_image',
                                        $omikujiItemImagePath
                                    );
                                    if ($imageItem) {
                                        $omikujiItem->update([
                                                'name' => $item,
                                                'rate_weight' => $inputs['rate_weight'][$key],
                                                'point' => $inputs['point'][$key],
                                                'image' => $imageItem,
                                            ]);
                                    } else {
                                        DB::rollback();

                                        return false;
                                    }
                                }
                                 $omikujiItem->update([
                                        'name' => $item,
                                        'rate_weight' => $inputs['rate_weight'][$key],
                                        'point' => $inputs['point'][$key],
                                    ]);
                            } else {
                                DB::rollback();

                                return false;
                            }
                        }
                    }
                } else {
                    DB::rollback();

                    return false;
                }
                DB::commit();

                return $omikuji->id;
            } else {
                DB::rollback();

                return false;
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }

    public static function deleteOmikujiItem($id)
    {
        $omikujiItem = OmikujiItem::find($id);

        if ($omikujiItem) {
            DB::beginTransaction();
            try {
                $omikujiItem->delete();
                DB::commit();

                return true;
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e);

                return false;
            }
        }
        Log::error("omikuji item doesn't exist");

        return false;
    }
    public static function deleteOmikuji($id)
    {
        $omikuji = Omikuji::find($id);
        if ($omikuji) {
            DB::beginTransaction();
            try {
                $omikuji->delete();
                DB::commit();

                return true;
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e);

                return false;
            }
        }
        Log::error("omikuji doesn't exist");

        return false;
    }

    public static function checkRecord($omikujiId)
    {
        $count = OmikujiItem::where('omikuji_id', $omikujiId)->count();
        if ($count > 1) {
            return true;
        }

        return false;
    }
}
