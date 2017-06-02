<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\ArticleRankService;
use App\Services\Admin\ArticleService as AdminArticleService;
use App\Services\Web\ArticleService as WebArticleService;
use App\Services\Admin\BannerSettingService;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\Web\CategoryService;
use App\Models\Tag;
use App\Services\Web\TagService;
use App\Services\Web\PopularSeriesService;

class HomesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->viewData['popularSeries'] = PopularSeriesService::getPopularSeries($this->currentLocaleId);

        $articleRanks = ArticleRankService::getArticleRanksLocale($this->currentLocaleId);
        $checkDisplay = 0;
        foreach ($articleRanks as $articleRank) {
            if (isset($articleRank->articleLocale)) {
                $checkDisplay += 1;
            }
        }

        $this->viewData['checkDisplay'] = $checkDisplay;
        $this->viewData['articleRanks'] = $articleRanks;
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
}
