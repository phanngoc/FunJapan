<?php

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use DB;
use App;

class CategoryService extends BaseService
{
    public static function listCategory()
    {
        $categories = Category::where('locale_iso_code', '=', App::getLocale())
            ->orWhere('locale_iso_code', '=', null)->get();
        return $categories;
    }

    public static function getAllCategories()
    {
        $add = trans('admin/article.select_category');
        $categories = Category::pluck('name', 'id')->prepend($add, '')->toArray();

        return $categories;
    }
}