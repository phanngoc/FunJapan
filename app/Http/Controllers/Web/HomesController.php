<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\ArticleRankService;
use App\Services\Admin\ArticleService as AdminArticleService;
use App\Services\Web\ArticleService as WebArticleService;
use App\Services\Admin\BannerSettingService;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Services\Web\CategoryService;

class HomesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->viewData['popularPost'] = AdminArticleService::getPopularPost($this->currentLocaleId);
        $this->viewData['banners'] = BannerSettingService::getBannerViaLocale($this->currentLocaleId);
        $this->viewData['articleRanks'] = ArticleRankService::getArticleRanksLocale($this->currentLocaleId);
        $this->viewData['newArticles'] = WebArticleService::getNewArticles($this->currentLocaleId, config('limitation.new_post.per_page'));
        $this->viewData['recommendArticles'] = WebArticleService::getRecommendArticles($this->currentLocaleId);

        $this->viewData['advertisementSrc'] = config('advertisement_banner.src.en');
        if (in_array($this->currentLocale, array_keys(config('advertisement_banner.src')))) {
            $this->viewData['advertisementSrc'] = config('advertisement_banner.src.' . $this->currentLocale);
            $this->viewData['newArticles'] = WebArticleService::getNewArticles(
                $this->currentLocaleId,
                config('limitation.new_post.per_page')
            );
        }

        if ($request->has('category')) {
            return $this->category($request->get('category'));
        }

        return view('web.home.index', $this->viewData);
    }

    public function category($categoryName)
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
