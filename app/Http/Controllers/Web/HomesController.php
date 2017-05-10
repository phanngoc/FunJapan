<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\ArticleRankService;
use App\Services\Admin\ArticleService as AdminArticleService;
use App\Services\Web\ArticleService as WebArticleService;
use App\Services\Admin\BannerSettingService;

class HomesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->viewData['popularPost'] = AdminArticleService::getPopularPost($this->currentLocaleId);
        $this->viewData['banners'] = BannerSettingService::getBannerViaLocale($this->currentLocaleId);
        $this->viewData['articleRanks'] = ArticleRankService::getArticleRanksLocale($this->currentLocaleId);
        $this->viewData['newArticles'] = WebArticleService::getNewArticles($this->currentLocaleId, config('limitation.new_post.per_page'));

        return view('web.home.index', $this->viewData);
    }
}
