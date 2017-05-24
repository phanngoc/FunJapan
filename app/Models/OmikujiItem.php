<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OmikujiItem extends BaseModel
{
    protected $table = 'omikuji_items';

    protected $fillable = [
        'name',
        'rate_weight',
        'point',
        'image',
        'omikuji_id',
    ];

    public function omikuji()
    {
        return $this->belongsTo(Omikuji::class);
    }

    public function getImageUrlsAttribute()
    {
        $results = [];
        if ($this->image) {
            try {
                foreach (config('images.dimensions.omikuji_item_image') as $key => $value) {
                    if ($key == 'original') {
                        $filePath = config('images.paths.omikuji_item_image') . '/' . $this->id . '/' . $this->image;
                    } else {
                        $filePath = config('images.paths.omikuji_item_image') . '/' . $this->id . '/' . $key . '_';
                        $filePath = $filePath . $this->image;
                    }
                    $results[$key] = ImageService::imageUrl($filePath);
                }

                return $results;
            } catch (Exception $e) {
                Log::debug($e);
            }
        }

        foreach (config('images.dimensions.omikuji_item_image') as $key => $value) {
            $results[$key] = null;
        }

        return $results;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($omikujiItem) {
            $imagePath = config('images.paths.omikuji_item_image') . '/' . $omikujiItem->id;
            if ($omikujiItem->image) {
                ImageService::delete($imagePath);
            }
        });
    }
}
