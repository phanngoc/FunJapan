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

    public function faq()
    {
        return view('web.guide.' . $this->currentLocale . '.faq', $this->viewData);
    }

    public function contactUs()
    {
        return view('web.guide.' . $this->currentLocale . '.contact_us', $this->viewData);
    }

    public function privacyPolicies()
    {
        return view('web.guide.' . $this->currentLocale . '.privacy_policies', $this->viewData);
    }

    public function aboutFunJapanPoints()
    {
        return view('web.guide.' . $this->currentLocale . '.point', $this->viewData);
    }

    public function inquiry()
    {
        return view('web.guide.inquiry', $this->viewData);
    }

    public function termsAndConditions()
    {
        return view('web.guide.' . $this->currentLocale . '.terms_conditions', $this->viewData);
    }

    public function articleSeries()
    {
        return view('web.guide.' . $this->currentLocale . '.article_series', $this->viewData);
    }
}
