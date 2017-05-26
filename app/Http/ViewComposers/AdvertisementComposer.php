<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Services\Admin\BannerSettingService;
use App;
use App\Services\Web\LocaleService;

class AdvertisementComposer
{
    public function compose(View $view)
    {
        if (in_array(App::getLocale(), array_keys(config('advertisement_banner.src')))) {
            $view->with('advertisementSrc', config('advertisement_banner.src.' . App::getLocale()));
        }
    }
}
