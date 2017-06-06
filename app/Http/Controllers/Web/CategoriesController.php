<?php

namespace App\Http\Controllers\Web;

use App\Services\Web\CategoryService;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show($categoryName)
    {
        $category = Category::where('short_name', $categoryName)->first();

        if ($category) {
            $this->viewData['articles'] = CategoryService::getArticleByCategory($category, $this->currentLocaleId);
            $this->viewData['category'] = $category;

            return view('web.categories.show', $this->viewData);
        } else {
            return response(trans('web/global.error'), 404);
        }
    }
}
