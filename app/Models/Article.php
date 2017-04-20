<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends BaseModel
{

    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'is_top_article',
    ];

    public function articleLocales()
    {
        return $this->hasMany(ArticleLocale::class);
    }

    public function articleTags()
    {
        return $this->hasMany(ArticleTag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
