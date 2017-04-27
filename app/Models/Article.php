<?php

namespace App\Models;

use Carbon\Carbon;

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
        'post_photo',
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

    public function getRelateArticle($localeId)
    {
        $result = [];
        $arrIgnoreIds = [$this->id];

        // get article same category
        $result['category'] = $this->commonQueryGetRelate($arrIgnoreIds, $localeId, config('article.relate_article.same_category'));

        if ($result['category']) {
            $arrIgnoreIds = array_merge($arrIgnoreIds, array_pluck($result['category'], 'id'));
        }

        // get article same tag
        $tags = $this->articleTags->pluck('tag_id');
        $result['tag'] = $this->commonQueryGetRelate($arrIgnoreIds, $localeId, config('article.relate_article.same_tag'), false, $tags);

        if ($result['tag']) {
            $arrIgnoreIds = array_merge($arrIgnoreIds, array_pluck($result['tag'], 'id'));
        }

        // get article random
        $result['random'] = $this->commonQueryGetRelate($arrIgnoreIds, $localeId, config('article.relate_article.random'), false);

        return $result;
    }

    public function commonQueryGetRelate($arrIgnoreIds, $localeId, $limit = 1, $isSameCategory = true, $tags = null)
    {
        $query = self::inRandomOrder()
            ->whereNotIn('id', $arrIgnoreIds)
            ->whereIn('id', function ($subQueryLocale) use ($localeId) {
                $subQueryLocale->select('article_id')
                    ->from('article_locales')
                    ->where('locale_id', $localeId)
                    ->where('published_at', '<=', Carbon::now());
            })
            ->limit($limit);

        if ($isSameCategory) {
            $query->where('category_id', $this->category_id);
        }

        if ($tags) {
            $query->whereIn('id', function ($subQuery) use ($tags) {
                $subQuery->select('article_id')
                    ->from('article_tags')
                    ->whereIn('tag_id', $tags);
            });
        }

        return $query->get(['id'])->toArray();
    }
}
