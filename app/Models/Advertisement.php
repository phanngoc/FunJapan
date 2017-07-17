<?php

namespace App\Models;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Advertisement extends Model
{
    protected $table = 'advertisements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'url',
        'photo',
        'locale_id',
        'is_not_publish',
    ];

    protected $appends = [
        'photo_urls',
        'active',
    ];

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function getPhotoUrlsAttribute()
    {
        if ($this->photo) {
            $results = [];

            try {
                foreach (config('images.dimensions.advertisement') as $key => $value) {
                    if ($key == 'original') {
                        $filePath = config('images.paths.advertisement') . '/' . $this->id . '/' . $this->photo;
                    } else {
                        $filePath = config('images.paths.advertisement') . '/' . $this->id . '/' . $key . '_' . $this->photo;
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

    public function getActiveAttribute()
    {
        if ($this->is_not_publish) {
            return false;
        }

        $locale = $this->locale;
        if ($locale) {
            $isoCode = $locale->iso_code;

            $now = Carbon::now(trans('datetime.time_zone', [], $isoCode));
            $startDay = Carbon::parse($this->start_date, trans('datetime.time_zone', [], $isoCode));
            $endDay = Carbon::parse($this->end_date . ' 23:59:59', trans('datetime.time_zone', [], $isoCode));


            return ($now->gte($startDay)) && ($now->lte($endDay));
        }

        return false;
    }
}
