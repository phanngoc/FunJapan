<?php

namespace App\Models;

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

    public function getRelateArticle()
    {
        $result = [];
        $arrIgnoreIds = [$this->id];

        // get article same category
        $result['category'] = self::inRandomOrder()
            ->where('category_id', $this->category_id)
            ->whereNotIn('id', $arrIgnoreIds)
            ->limit(config('article.relate_article.same_category'))
            ->get(['id', 'photo'])
            ->toArray();

        if ($result['category']) {
            $arrIgnoreIds = array_merge($arrIgnoreIds, array_pluck($result['category'], 'id'));
        }

        // get article same tag
        $tags = $this->articleTags->pluck('tag_id');
        $result['tag'] = self::inRandomOrder()
            ->whereIn('id', function ($subQuery) use ($tags) {
                $subQuery->select('article_id')
                    ->from('article_tags')
                    ->whereIn('tag_id', $tags);
            })
            ->whereNotIn('id', $arrIgnoreIds)
            ->limit(config('article.relate_article.same_tag'))
            ->get(['id', 'photo'])
            ->toArray();

        if ($result['tag']) {
            $arrIgnoreIds = array_merge($arrIgnoreIds, array_pluck($result['tag'], 'id'));
        }

        // get article random
        $result['random'] = self::inRandomOrder()
            ->whereNotIn('id', $arrIgnoreIds)
            ->limit(config('article.relate_article.random'))
            ->get(['id', 'photo'])
            ->toArray();

        return $result;
    }
}
