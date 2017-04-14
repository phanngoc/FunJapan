<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use App\Models\ArticleLocale;
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
}
