<?php

namespace App\Services\Web;

use App\Models\CategoryLocale;
use App\Models\ArticleLocale;
use Carbon\Carbon;

class CategoryService
{
    public static function getCategoryName($id, $localeId)
    {
        $categoryLocale = CategoryLocale::where('category_id', $id)
            ->where('locale_id', $localeId)
            ->first();

        return $categoryLocale->name ?? '';
    }

    public static function getArticleByCategory($category, $localeId)
    {
        //TODO: recode

        return ArticleLocale::with('article', 'articleTags')
            ->where('locale_id', $localeId)
            ->where('category_id', $category->id)
            ->where('hide', 0)
            ->where('published_at', '<=', Carbon::now())
//            ->orderBy('is_top_article', 'DESC')
            ->orderBy('published_at', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->orderBy('title', 'DESC')
            ->paginate(config('limitation.article_category.per_page'));
    }
}
