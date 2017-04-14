<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Web\ArticleService;
use App\Services\Web\CategoryService;

class ArticlesController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->viewData['title'] = trans('web/global.title');
    }

    public function show($id)
    {
        $articleLocale = ArticleService::getArticleDetails($id, $this->currentLocaleId);
        if (!$articleLocale) {
            return view('web.articles.show', $this->viewData)->withErrors(trans('web/global.error'));
        }

        if (isset($articleLocale->article->category)) {
            $categoryId = $articleLocale->article->category->id;
            $categoryName = CategoryService::getCategoryName($categoryId, $this->currentLocaleId);
            $this->viewData['categoryName'] = $categoryName;
        } else {
            return view('web.articles.show', $this->viewData)->withErrors(trans('web/global.error'));
        }

        $this->viewData['articleLocale'] = $articleLocale;

        return view('web.articles.show', $this->viewData);
    }
}
