<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ArticleLocale;

class ArticleTag extends BaseModel
{

    protected $table = 'article_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_locale_id',
        'article_id',
        'tag_id',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function tagLocales()
    {
        return $this->hasMany(TagLocale::class);
    }

    public function articleLocale()
    {
        return $this->belongsTo(ArticleLocale::class, 'article_locale_id', 'id');
    }
}
