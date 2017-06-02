<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App;
use App\Services\Web\LocaleService;
use App\Services\Admin\ArticleService;

class PopularPostComposer
{
    public function compose(View $view)
    {
        $currentLocale = LocaleService::getLocaleByIsoCode(App::getLocale());
        $currentLocaleId = $currentLocale->id;

        $popularPost = ArticleService::getPopularPost($currentLocaleId);

        $view->with('popularPost', $popularPost);
    }
}
