<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ArticleLocale extends BaseModel
{

    protected $table = 'article_locales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'article_id',
        'title',
        'content',
        'like_count',
        'comment_count',
        'share_count',
        'view_count',
        'published_at',
    ];

    protected $dates = ['published_at'];

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
}
