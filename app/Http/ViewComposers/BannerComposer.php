<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Services\Admin\BannerSettingService;
use App;
use App\Services\Web\LocaleService;

class BannerComposer
{
    public function compose(View $view)
    {
        $currentLocale = LocaleService::getLocaleByIsoCode(App::getLocale());
        $currentLocaleId = $currentLocale->id;

        $banners = BannerSettingService::getBannerViaLocale($currentLocaleId);

        $view->with('banners', $banners);
    }
}
