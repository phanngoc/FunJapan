<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Services\ImageService;
use App\Services\Admin\CategoryService;
use App\Services\Admin\TagService;

class PopularSeries extends BaseModel
{

    protected $table = 'popular_series';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'summary',
        'photo',
        'type',
        'link',
    ];

    protected $appends = [
        'photo_urls',
        'name_link',
    ];

    public function getPhotoUrlsAttribute()
    {
        $result = [];
        try {
            foreach (config('images.dimensions.popular_series_image') as $key => $value) {
                $filePath = config('images.paths.popular_series_image') .
                    '/' . $this->id . '/' . $key . '_' . $this->photo;

                $result[$key] = ImageService::imageUrl($filePath);
            }

            return $result;
        } catch (\Exception $e) {
            Log::debug($e);
        }
    }

    public function getNameLinkAttribute()
    {
        if ($this->type == config('popular_series.type.tag')) {
            $tag = TagService::getTag($this->link);

            return $tag->name;
        } else {
            $category = CategoryService::getCategory($this->link);

            return $category->short_name;
        }
    }
}
