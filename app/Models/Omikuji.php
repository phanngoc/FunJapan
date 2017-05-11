<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Omikuji extends BaseModel
{
    protected $table = 'omikujis';

    protected $fillable = [
        'name',
        'image',
        'start_time',
        'end_time',
        'recover_time',
        'locale_id',
        'description',
    ];

    public function getStatusAttribute()
    {
        $now = Carbon::now();
        if ($this->start_time) {
            if ($now->gte(Carbon::parse($this->start_time))) {
                if ($this->end_time) {
                    if ($now->gt(Carbon::parse($this->end_time))) {
                        return 'Stopped';
                    }
                }

                return 'Running';
            } else {
                return 'Stopped';
            }
        }

        return '';
    }

    public function omikujiItems()
    {
        return $this->hasMany(OmikujiItem::class);
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function getLocaleNameAttribute()
    {
        if ($this->locale_id) {
            return $this->locale->name;
        }

        return '';
    }

    public function getImageUrlsAttribute()
    {
        $results = [];
        if ($this->image) {
            try {
                foreach (config('images.dimensions.omikuji_image') as $key => $value) {
                    if ($key == 'original') {
                        $filePath = config('images.paths.omikuji_image') . '/' . $this->id . '/' . $this->image;
                    } else {
                        $filePath = config('images.paths.omikuji_image') . '/' . $this->id . '/' . $key . '_';
                        $filePath = $filePath . $this->image;
                    }
                    $results[$key] = ImageService::imageUrl($filePath);
                }

                return $results;
            } catch (Exception $e) {
                Log::debug($e);
            }
        }

        foreach (config('images.dimensions.omikuji_image') as $key => $value) {
            $results[$key] = null;
        }

        return $results;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($omikuji) {
            $imagePath = config('images.paths.omikuji_image') . '/' . $omikuji->id;
            foreach ($omikuji->omikujiItems()->get() as $omikujiItem) {
                $omikujiItem->delete();
            }
            if ($omikuji->image) {
                ImageService::delete($imagePath);
            }
        });
    }
}
