<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\LocaleService;
use App\Services\Admin\ArticleLocaleService;
use App\Services\Admin\ArticleRankService;

class ArticleRanksController extends Controller
{
    public function index()
    {
        $locales = LocaleService::getAllLocales();
        $this->viewData['locales'] = $locales;
        $this->viewData['articleRanks'] = ArticleRankService::getAllArticleRanks($locales);

        return view('admin.article_ranks.index', $this->viewData);
    }

    public function getArticleLocales(Request $request, $localeId)
    {
        $condition = [
            'key_search' => $request->q,
            'locale_id' => $localeId,
        ];

        return ArticleLocaleService::getListForRank($condition);
    }

    public function store(Request $request, $localeId)
    {
        $arrayArticleLocaleId = [];
        $message = [];
        if (isset($request->articleRank)) {
            foreach ($request->articleRank as $rank => $articleLocaleId) {
                if (isset($articleLocaleId) && $position = array_search($articleLocaleId, $arrayArticleLocaleId)) {
                    $message[] = [
                        $position => trans('admin/article_rank.duplicate'),
                        $rank => trans('admin/article_rank.duplicate'),
                    ];
                }

                $arrayArticleLocaleId[$rank] = $articleLocaleId;
            }

            if ($message) {
                return response()->json([
                    'message' => $message,
                ]);
            } else {
                foreach ($request->articleRank as $rank => $articleLocaleId) {
                    $input = [
                        'article_locale_id' => $articleLocaleId,
                        'locale_id' => $localeId,
                        'rank' => $rank,
                    ];
                    ArticleRankService::store($input);
                }
            }
        }
    }
}
