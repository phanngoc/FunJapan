<?php

namespace App\Models;

use App\Services\ImageService;
use Carbon\Carbon;

class BannerSetting extends BaseModel
{

    protected $table = 'banner_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_locale_id',
        'locale_id',
        'photo',
        'order',
    ];

    protected $appends = [
        'photo_urls',
        'active',
        'order_text',
    ];

    public function articleLocale()
    {
        return $this->belongsTo(ArticleLocale::class);
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function getPhotoUrlsAttribute()
    {
        if ($this->photo) {
            $results = [];

            try {
                foreach (config('images.dimensions.banner') as $key => $value) {
                    if ($key == 'original') {
                        $filePath = config('images.paths.banner') . '/' . $this->id . '/' . $this->photo;
                    } else {
                        $filePath = config('images.paths.banner') . '/' . $this->id . '/' . $key . '_' . $this->photo;
                    }

                    $results[$key] = ImageService::imageUrl($filePath);
                }

                return $results;
            } catch (Exception $e) {
                \Log::debug($e);
            }
        }

        foreach (config('images.dimensions.banner') as $key => $value) {
            $results[$key] = null;
        }

        return $results;
    }

    public function getOrderTextAttribute()
    {
        $orders = array_flip(config('banner.order'));

        return trans('admin/banner.order.' . $orders[$this->order]);
    }

    public function getActiveAttribute()
    {
        return $this->articleLocale->status_show_in_front;
    }
}
