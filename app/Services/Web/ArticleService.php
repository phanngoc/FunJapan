<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use App\Models\ArticleLocale;
use App\Models\FavoriteArticle;
use App\Services\Web\LocaleService;
use Illuminate\Support\Facades\App;

class ArticleService
{
    public static function getArticleDetails($id, $localeId)
    {
        return ArticleLocale::where('article_id', $id)
            ->where('locale_id', $localeId)
            ->first();
    }

    public static function getFavoriteArticleDetails($userId, $articleId, $articleLocaleId)
    {
        return FavoriteArticle::where('user_id', $userId)
            ->where('article_id', $articleId)
            ->where('article_locale_id', $articleLocaleId)
            ->first();
    }

    public static function countLike($userId, $articleId, $localeId)
    {
        $articleLocale = ArticleService::getArticleDetails($articleId, $localeId);
        $favorite = ArticleService::getFavoriteArticleDetails($userId, $articleId, $articleLocale->id);
        if ($favorite == null) {
            $data = [
                'user_id' => $userId,
                'article_id' => $articleId,
                'article_locale_id' => $articleLocale->id,
            ];
            FavoriteArticle::create($data);
            $articleLocale->increment('like_count');
        } else {
            $favorite->delete();
            $articleLocale->decrement('like_count');
        }

        return response()->json([
            'count' => $articleLocale->like_count,
            'check' => !$favorite ? true : false,
        ]);
    }
}
