<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Services\Web\AdvertisementService;
use App;

class AdvertisementComposer
{
    public function compose(View $view)
    {
        if (in_array(App::getLocale(), array_keys(config('advertisement_banner.src')))) {
            $view->with('advertisement', AdvertisementService::getAdvertisement(App::getLocale()));
        }
    }
}
