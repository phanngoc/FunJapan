<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\CategoryService;
use App\Services\ImageService;

class PopularCategory extends Model
{
    protected $table = 'popular_categories';

    protected $fillable = [
        'name',
        'photo',
        'locale_id',
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
            foreach (config('images.dimensions.popular_category_image') as $key => $value) {
                $filePath = config('images.paths.popular_category_image') .
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
        $category = CategoryService::getCategory($this->link);
        return $category->short_name;
    }
}
