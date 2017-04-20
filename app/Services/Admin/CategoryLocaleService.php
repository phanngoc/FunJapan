<?php

namespace App\Services\Admin;

use App\Models\CategoryLocale;

class CategoryLocaleService extends BaseService
{
    public static function getCategories()
    {
        return CategoryLocale::all()->groupBy('locale_id');
    }
}
