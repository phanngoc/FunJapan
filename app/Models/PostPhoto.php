<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostPhoto extends BaseModel
{

    protected $table = 'post_photos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'article_locale_id',
        'photo',
        'content',
        'user_id',
    ];
}
