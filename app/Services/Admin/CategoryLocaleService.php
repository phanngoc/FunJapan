<?php

namespace App\Services\Admin;

use App\Models\CategoryLocale;

class CategoryLocaleService extends BaseService
{
    public static function getCategories()
    {
        $add = ['category_id' => '', 'name' => trans('admin/article.select_category')];
        $categories = CategoryLocale::all()->groupBy('locale_id');
        foreach ($categories as $category) {
            $category->prepend($add);
        }

        return $categories;
    }
}
