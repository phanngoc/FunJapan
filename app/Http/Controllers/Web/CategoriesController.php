<?php

namespace App\Http\Controllers\Web;

use App\Services\Web\CommentService;
use App\Services\Admin\ArticleService;
use App\Services\Web\CategoryService;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\Web\PopularSeriesService;

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
            $this->viewData['popularPost'] = ArticleService::getPopularPost($this->currentLocaleId);
            $this->viewData['articles'] = CategoryService::getArticleByCategory($category, $this->currentLocaleId);
            $this->viewData['category'] = $category;
            $this->viewData['popularSeries'] = PopularSeriesService::getPopularSeries($this->currentLocaleId);

            return view('web.categories.show', $this->viewData);
        } else {
            return response(trans('web/global.error'), 404);
        }
    }
}
