<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Services\ImageService;
use GrahamCampbell\Markdown\Facades\Markdown;

class Coupon extends BaseModel
{

    protected $table = 'coupons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'can_get_from',
        'can_get_to',
        'can_use_from',
        'can_use_to',
        'max_coupon',
        'max_coupon_per_user',
        'required_point',
        'image',
        'pin',
        'pin_code',
    ];

    protected $appends = [
        'html_description',
        'status',
        'image_all',
    ];

    public function getNameAttribute()
    {
        return htmlspecialchars($this->attributes['name']);
    }

    public function getStatusAttribute()
    {
        $now = "DATE_FORMAT('" . Carbon::now() . "', '%Y-%m-%d %h:%i:%s') ";
        $result = Coupon::query()->selectRaw("*,
            (CASE
                WHEN $now >= can_get_from && $now <= can_get_to AND  (SELECT COUNT(user_id) FROM coupons
                    INNER JOIN coupon_users ON coupon_users.coupon_id = coupons.id) < max_coupon THEN '".trans('admin/coupon.running')."'
                ELSE '".trans('admin/coupon.stopped')."'
            END) AS `status_at`")->where('id', $this->id);

        return $result->first()->status_at;
    }

    public function getHtmlDescriptionAttribute($value)
    {
        return Markdown::convertToHtml($this->description);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_users', 'coupon_id', 'user_id');
    }

    public function getImageAllAttribute()
    {
        $results = [];
        if ($this->image) {
            try {
                foreach (config('images.dimensions.coupon_image') as $key => $value) {
                    if ($key == 'original') {
                        $filePath = config('images.paths.coupon_image') . '/' . $this->id . '/' . $this->image;
                    } else {
                        $filePath = config('images.paths.coupon_image') . '/' . $this->id . '/' . $key . '_' .
                        $this->icon;
                    }
                    $results[$key] = ImageService::imageUrl($filePath);
                }

                return $results;
            } catch (Exception $e) {
                Log::debug($e);
            }
        }

        foreach (config('images.dimensions.coupon_image') as $key => $value) {
            $results[$key] = null;
        }

        return $results;
    }
}
