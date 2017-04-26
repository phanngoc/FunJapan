<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleRank extends Model
{
    protected $table = 'article_ranks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'article_locale_id',
        'rank',
    ];

    public function articleLocale()
    {
        return $this->belongsTo(ArticleLocale::class);
    }
}
