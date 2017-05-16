<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoriteArticle extends BaseModel
{
    use SoftDeletes;
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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($favorite) {
            if ($favorite->articleLocale) {
                $favorite->articleLocale->decrement('like_count');
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function articleLocale()
    {
        return $this->belongsTo(ArticleLocale::class);
    }
}
