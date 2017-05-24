<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\CategoryLocale;
use App\Models\ArticleLocales;
use App\Services\Web\LocaleService;
use Illuminate\Support\Facades\App;
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
        return $category->articles()
            ->select('articles.*')
            ->leftJoin('article_locales as al', 'al.article_id', '=', 'articles.id')
            ->with(['articleLocales' => function ($query) use ($localeId) {
                return $query->where('locale_id', $localeId);
            },
            'articleTags' => function ($query) use ($localeId) {
                return $query->join('article_locales as al', 'al.id', '=', 'article_tags.article_locale_id')
                    ->join('tags as ta', 'ta.id', '=', 'article_tags.tag_id')
                    ->where('al.locale_id', $localeId)
                    ->where('ta.status', config('tag.status.un_block'));
            },
            ])
            ->where('al.hide_always', 0)
            ->where('al.locale_id', $localeId)
            ->where('published_at', '<=', Carbon::now())
            ->orderBy('al.is_top_article', 'DESC')
            ->orderBy('al.published_at', 'DESC')
            ->orderBy('al.created_at', 'DESC')
            ->orderBy('al.title', 'DESC')
            ->paginate(config('limitation.article_category.per_page'));
    }
}
