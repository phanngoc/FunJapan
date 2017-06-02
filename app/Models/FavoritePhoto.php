<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoritePhoto extends BaseModel
{

    protected $table = 'favorite_photos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_photo_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($favorite) {
            if ($favorite->photo) {
                $favorite->photo->decrement('favorite_count');
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photo()
    {
        return $this->belongsTo(PostPhoto::class, 'post_photo_id', 'id');
    }
}
