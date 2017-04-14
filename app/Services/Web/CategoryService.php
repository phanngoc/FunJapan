<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\CategoryLocale;
use App\Services\Web\LocaleService;
use Illuminate\Support\Facades\App;

class CategoryService
{
    public static function getCategoryName($id, $localeId)
    {
        $categoryLocale = CategoryLocale::where('category_id', $id)
            ->where('locale_id', $localeId)
            ->first();

        return $categoryLocale->name ?? '';
    }
}
