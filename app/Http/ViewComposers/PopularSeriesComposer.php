<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App;
use App\Services\Web\LocaleService;
use App\Services\Web\PopularSeriesService;

class PopularSeriesComposer
{
    public function compose(View $view)
    {
        $currentLocale = LocaleService::getLocaleByIsoCode(App::getLocale());
        $popularSeries = PopularSeriesService::getPopularSeries($currentLocale->id);

        $view->with('popularSeries', $popularSeries);
    }
}
