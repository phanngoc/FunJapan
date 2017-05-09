<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\BannerSettingService;
use App\Services\Admin\ArticleService;

class GuidesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->viewData['popularPost'] = ArticleService::getPopularPost($this->currentLocaleId);
        $this->viewData['banners'] = BannerSettingService::getBannerViaLocale($this->currentLocaleId);
    }

    public function about()
    {
        return view('web.guide.' . $this->currentLocale . '.about', $this->viewData);
    }

    public function footPrint()
    {
        return view('web.guide.' . $this->currentLocale . '.footprint', $this->viewData);
    }

    public function staff()
    {
        return view('web.guide.' . $this->currentLocale . '.staff', $this->viewData);
    }

    public function previousCampaigns()
    {
        return view('web.guide.' . $this->currentLocale . '.previous_campaigns', $this->viewData);
    }
}
