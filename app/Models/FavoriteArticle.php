<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteArticle extends BaseModel
{

    protected $table = 'favorite_articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'article_id',
        'article_locale_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
