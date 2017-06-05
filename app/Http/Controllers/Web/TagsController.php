<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\ArticleService;
use App\Services\Web\CategoryService;
use App\Services\Web\TagService;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Services\Web\PopularSeriesService;
use App\Services\Web\PopularCategoryService;

class TagsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show($tagName)
    {
        $tag = Tag::where('name', $tagName)->first();

        if ($tag) {
            $this->viewData['articles'] = TagService::getArticleByTag($tag, $this->currentLocaleId);
            $this->viewData['tag'] = $tag;
            $this->viewData['popularSeries'] = PopularSeriesService::getPopularSeries($this->currentLocaleId);
            $this->viewData['popularCategories'] = PopularCategoryService::getPopularCategories($this->currentLocaleId);

            return view('web.tags.show', $this->viewData);
        } else {
            return response(trans('web/global.error'), 404);
        }
    }
}
