<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\ArticleRankService;
use App\Services\Admin\ArticleService;
use App\Services\Admin\BannerSettingService;

class HomesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->viewData['popularPost'] = ArticleService::getPopularPost($this->currentLocaleId);
        $this->viewData['banners'] = BannerSettingService::getBannerViaLocale($this->currentLocaleId);
        $this->viewData['articleRanks'] = ArticleRankService::getArticleRanksLocale($this->currentLocaleId);

        return view('web.home.index', $this->viewData);
    }
}
