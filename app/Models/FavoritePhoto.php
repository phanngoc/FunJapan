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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photo()
    {
        return $this->belongsTo(PostPhoto::class);
    }
}
