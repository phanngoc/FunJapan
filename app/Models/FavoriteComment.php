<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteComment extends BaseModel
{

    protected $table = 'favorite_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'comment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
