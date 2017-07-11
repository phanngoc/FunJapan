<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\ImageService;
use Log;

class Author extends Model
{
    protected $table = 'authors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'photo',
        'description',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function getPhotoUrlAttribute($value)
    {
        if ($this->photo) {
            $results = [];

            try {
                foreach (config('images.dimensions.author') as $key => $value) {
                    if ($key == 'original') {
                        $filePath = config('images.paths.author') . '/' . $this->id . '/' . $this->photo;
                    } else {
                        $filePath = config('images.paths.author') . '/' . $this->id . '/' . $key . '_' . $this->photo;
                    }

                    $results[$key] = ImageService::imageUrl($filePath);
                }

                return $results;
            } catch (Exception $e) {
                Log::debug($e);
            }
        }
    }
}
