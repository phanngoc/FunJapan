<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\ArticleRankService;
use App\Services\Admin\ArticleService as AdminArticleService;
use App\Services\Web\ArticleService as WebArticleService;
use Illuminate\Http\Request;

class HomesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $articleRanks = ArticleRankService::getArticleRanksLocale($this->currentLocaleId);
        $rank1 = $articleRanks->splice(0, 1);
        $checkDisplay = 0;
        foreach ($articleRanks as $articleRank) {
            if (isset($articleRank->articleLocale)) {
                $checkDisplay += 1;
            }
        }

        $this->viewData['checkDisplay'] = $checkDisplay;
        $this->viewData['rank1'] = $rank1;
        $this->viewData['articleRanks'] = $articleRanks->all();
        $this->viewData['newArticles'] = WebArticleService::getNewArticles(
            $this->currentLocaleId,
            config('limitation.new_post.per_page')
        );
        $this->viewData['recommendArticles'] = WebArticleService::getRecommendArticles($this->currentLocaleId);

        if (in_array($this->currentLocale, array_keys(config('advertisement_banner.src')))) {
            $this->viewData['advertisementSrc'] = config('advertisement_banner.src.' . $this->currentLocale);
            $this->viewData['newArticles'] = WebArticleService::getNewArticles(
                $this->currentLocaleId,
                config('limitation.new_post.per_page')
            );
        }

        return view('web.home.index', $this->viewData);
    }

    public function error()
    {
        return view('web.errors.404', $this->viewData);
    }
}
