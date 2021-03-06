<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Services\ImageService;
use App\Models\Article;

class Category extends BaseModel
{

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icon',
        'user_id',
        'short_name',
        'name',
        'mapping',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

//    public function categoryLocales()
//    {
//        return $this->hasMany(CategoryLocale::class);
//    }

//    public function articles()
//    {
//        return $this->hasMany(Article::class);
//    }

    public function interestUsers()
    {
        return $this->hasMany(InterestUser::class);
    }

    public function getIconUrlsAttribute()
    {
        $results = [];
        if ($this->icon) {
            try {
                foreach (config('images.dimensions.category_icon') as $key => $value) {
                    if ($key == 'original') {
                        $filePath = config('images.paths.category_icon') . '/' . $this->id . '/' . $this->icon;
                    } else {
                        $filePath = config('images.paths.category_icon') . '/' . $this->id . '/' . $key . '_' .
                        $this->icon;
                    }
                    $results[$key] = ImageService::imageUrl($filePath);
                }

                return $results;
            } catch (Exception $e) {
                Log::debug($e);
            }
        }

        foreach (config('images.dimensions.category_icon') as $key => $value) {
            $results[$key] = null;
        }

        return $results;
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
}
