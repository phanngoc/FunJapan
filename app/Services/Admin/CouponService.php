<?php

namespace App\Services\Admin;

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Services\ImageService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Validator;
use DB;
use Image;
use Auth;
use Carbon\Carbon;

class CouponService extends BaseService
{
    public static function create($inputs)
    {
        DB::beginTransaction();
        try {
            $coupon = Coupon::create(array_except($inputs, ['image']));

            if ($coupon) {
                $photoUploadPath = config('images.paths.coupon_image') . '/' . $coupon->id;
                $image = ImageService::uploadFile($inputs['image'], 'coupon_image', $photoUploadPath);
                if ($image) {
                    $coupon->update([
                        'image' => $image,
                    ]);
                } else {
                    DB::rollback();
                    return false;
                }
            } else {
                DB::rollback();
                return false;
            }

            DB::commit();

            return $coupon;
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
            $coupon = Coupon::find($id);

            if ($coupon) {
                $coupon->update(array_except($inputs, ['image']));
                $photoUploadPath = config('images.paths.coupon_image') . '/' . $coupon->id;
                if (isset($inputs['image'])) {
                    $image = ImageService::uploadFile($inputs['image'], 'coupon_image', $photoUploadPath, true);
                    if ($image) {
                        $coupon->update([
                            'image' => $image,
                        ]);
                    } else {
                        DB::rollback();
                        return false;
                    }
                }
            } else {
                DB::rollback();
                return false;
            }

            DB::commit();

            return $coupon;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }

    public static function delete($id)
    {
        DB::beginTransaction();
        try {
            $coupon = Coupon::find($id);

            if ($coupon) {
                $coupon->users()->sync([]);
                $photoUploadPath = config('images.paths.coupon_image') . '/' . $coupon->id;
                if ($coupon->image) {
                    ImageService::deleteAll('coupon_image', $photoUploadPath, $coupon->image);
                }
                $coupon->delete();
            } else {
                DB::rollback();
                return false;
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);

            return false;
        }
    }

    public static function find($id)
    {
        return Coupon::find($id);
    }

    public static function list($conditions)
    {
        $keyword = escape_like($conditions['search']['value']);
        $searchColumns = ['name', 'max_coupon', 'required_point', 'status'];
        $limit = $conditions['length'];
        $page = $conditions['start'] / $conditions['length'] + 1;
        $orderParams = $conditions['order'];
        $orderConditions['column'] = $conditions['columns'][$orderParams[0]['column']]['data'];
        $orderConditions['dir'] = $orderParams[0]['dir'];
        $query = Coupon::query();

        $now = "DATE_FORMAT('" . Carbon::now() . "', '%Y-%m-%d %h:%i:%s') ";

        $query->selectRaw(" *,
            (CASE
                WHEN $now >= can_get_from && $now <= can_get_to AND  (SELECT COUNT(user_id) FROM coupons
                    INNER JOIN coupon_users ON coupon_users.coupon_id = coupons.id) < max_coupon THEN '".trans('admin/coupon.running')."'
                ELSE '".trans('admin/coupon.stopped')."'
            END) AS `status`");

        $queryEx = DB::table(DB::raw("({$query->toSql()}) as a"))
            ->mergeBindings($query->getQuery());

        $results = static::listItems($queryEx, $keyword, $searchColumns, $orderConditions, $limit, $page);

        foreach ($results as $result) {
            $result->confirmDeleteMessage = trans('admin/coupon.delete_confirm');
        }

        return $returnData = [
            'recordsFiltered' => $results->total(),
            'data' => $results->items(),
        ];
    }

    public static function checkUsed($couponId)
    {
        return CouponUser::where('coupon_id', '=', $couponId)->count();
    }
}
