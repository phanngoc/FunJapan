<?php
namespace App\Services\Web;

use App\Models\PopularCategory;

class PopularCategoryService
{
    public static function getPopularCategories($localeId)
    {
        $popularCategories = PopularCategory::where('locale_id', $localeId)->get();

        return $popularCategories;
    }
}
