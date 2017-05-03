<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\ArticleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticleLocale;
use App\Services\Admin\LocaleService;
use Illuminate\Support\Facades\View;

class PopularArticlesController extends Controller
{
    public function index(Request $request)
    {
        $locales = LocaleService::getAllLocales();

        $input = $request->only('locale_id', 'keyword');
        $input['default_locale_id'] = key($locales);
        
        $articlesLocale = ArticleService::getListArticleForPopularPost($input);
        $popularPosts = ArticleService::getPopularPost($input['locale_id'] ? : $input['default_locale_id']);

        $this->viewData['popularPosts'] = $popularPosts;
        $this->viewData['articlesLocale'] = $articlesLocale;
        $this->viewData['input'] = $input;
        $this->viewData['locales'] = $locales;

        return view('admin.article.popular.index', $this->viewData);
    }

    public function store(Request $request)
    {
        //check login and permission (latter)
        if (!auth()->check()) {
            return [
                'success' => false,
                'message' => trans('admin/popular_article.messages.not_permission'),
            ];
        }

        return ArticleService::addPopularPost($request->get('articleLocaleId'));
    }

    public function destroy($id)
    {
        //check login and permission (latter)
        if (!auth()->check()) {
            return [
                'success' => false,
                'message' => trans('admin/popular_article.messages.not_permission'),
            ];
        }

        return ArticleService::deletePopularPost($id);
    }
}
