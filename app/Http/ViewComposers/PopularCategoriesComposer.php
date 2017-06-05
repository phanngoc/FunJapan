<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App;
use App\Services\Web\LocaleService;
use App\Services\Web\PopularCategoryService;

class PopularCategoriesComposer
{
    public function compose(View $view)
    {
        $currentLocale = LocaleService::getLocaleByIsoCode(App::getLocale());
        $popularCategories = PopularCategoryService::getPopularCategories($currentLocale->id);

        $view->with('popularCategories', $popularCategories);
    }
}
