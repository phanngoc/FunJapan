<?php
namespace App\Services\Web;

use App\Models\EditorChoice;
use App\Models\ArticleLocale;
use Carbon\Carbon;

class EditorChoicesService
{
    public static function getEditorChoices($localeId)
    {
        $editorChoicesArticleId = EditorChoice::pluck('article_id');

        return ArticleLocale::with('article', 'article.category', 'articleTags', 'articleTags.tag')
            ->where('locale_id', $localeId)
            ->whereIn('article_id', $editorChoicesArticleId)
            ->where('status', config('article.status.published'))
            ->where('hide', 0)
            ->whereNotNull('published_at')
            ->where('published_at', '<', Carbon::now())
            ->where('end_published_at', '>', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->orderBy('title', 'desc')
            ->get();
    }
}
