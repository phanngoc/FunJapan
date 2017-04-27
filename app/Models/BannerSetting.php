<?php

namespace App\Models;

use App\Services\ImageService;

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
    ];

    public function articleLocale()
    {
        return $this->belongsTo(ArticleLocale::class);
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
}
