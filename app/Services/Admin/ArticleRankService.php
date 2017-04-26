<?php

namespace App\Services\Admin;

use App\Models\ArticleLocale;
use App\Models\ArticleRank;
use DB;
use Validator;

class ArticleRankService extends BaseService
{
    public static function getAllArticleRanks($locales)
    {
        $result = [];

        foreach ($locales as $localeId => $localeName) {
            $result[$localeId] = self::getArticleRanksLocale($localeId);
        }

        return $result;
    }

    public static function getArticleRanksLocale($localeId)
    {
        return ArticleRank::where('locale_id', $localeId)
            ->limit(config('article.per_page'))
            ->orderBy('rank')
            ->get();
    }

    public static function store($input)
    {
        return ArticleRank::updateOrCreate(
            ['locale_id' => $input['locale_id'], 'rank' => $input['rank']],
            ['article_locale_id' => $input['article_locale_id']]
        );
    }

    public static function destroy($request, $localeId)
    {
        $articleRank = ArticleRank::where('locale_id', $localeId)
            ->where('article_locale_id', $request->articleLocaleId)
            ->where('rank', $request->rank)
            ->first();

        if (isset($articleRank)) {
            $articleRank->delete();
        }
    }
}
