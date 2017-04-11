<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends BaseModel
{

    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'content',
        'parent_id',
        'article_id',
        'article_locale_id',
        'user_id',
        'favorite_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
