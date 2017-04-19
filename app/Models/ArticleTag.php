<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
