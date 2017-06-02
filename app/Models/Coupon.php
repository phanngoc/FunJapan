<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Services\ImageService;

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
        'status',
        'image_all',
    ];

    public function getNameAttribute()
    {
        return htmlspecialchars($this->attributes['name']);
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
