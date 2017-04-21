<?php

namespace App\Services\Web;

use App\Models\Article;
use App\Models\ArticleLocale;
use App\Models\FavoriteArticle;
use App\Services\Web\LocaleService;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class ArticleService
{
    public static function getArticleLocaleDetails($id, $localeId)
    {
        return ArticleLocale::where('article_id', $id)
            ->where('locale_id', $localeId)
            ->whereNotNull('published_at')
            ->where('published_at', '<', Carbon::now())
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

    public static function getNextArticle($id, $localeId)
    {
        return ArticleLocale::where('id', '<', $id)
            ->where('locale_id', $localeId)
            ->whereNotNull('published_at')
            ->where('published_at', '<', Carbon::now())
            ->orderBy('id', 'desc')
            ->first();
    }

    public static function getArticleDetail($id, $localeId)
    {
        $article = Article::find($id);
        $article->locale = self::getArticleLocaleDetails($id, $localeId);
        $relates = $article->getRelateArticle();
        $relateArticle = [];

        foreach ($relates as $relateType) {
            if (count($relateType)) {
                foreach ($relateType as $articleRelate) {
                    $articleRelate['locale'] = self::getArticleLocaleDetails($articleRelate['id'], $localeId);
                    $relateArticle[] = $articleRelate;
                }
            }
        }

        $article->relateArticle = $relateArticle;

        return $article;
    }
}
