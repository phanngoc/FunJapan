<?php

namespace App\Http\Controllers\Web;

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
        $article = ArticleService::getArticleDetail($id, $this->currentLocaleId);
        if (!$article->locale) {
            return view('web.articles.show', $this->viewData)->withErrors(trans('web/global.error'));
        }

        if (isset($article->category)) {
            $categoryId = $article->category->id;
            $categoryName = CategoryService::getCategoryName($categoryId, $this->currentLocaleId);
            $this->viewData['categoryName'] = $categoryName;
        } else {
            return view('web.articles.show', $this->viewData)->withErrors(trans('web/global.error'));
        }

        $this->viewData['nextArticle'] = ArticleService::getNextArticle($article->locale->id, $this->currentLocaleId);
        $this->viewData['article'] = $article;
        $this->viewData['title'] = trans('web/global.title', ['article_title' => $article->locale->title]);
        $this->viewData['photo'] = $article->photo;

        if (auth()->check()) {
            $this->viewData['favorite'] = ArticleService::getFavoriteArticleDetails(
                auth()->user()->id,
                $article->id,
                $article->locale->id
            );
        }

        return view('web.articles.show', $this->viewData);
    }

    public function countLike($articleId, Request $request)
    {
        if (!auth()->check()) {
            return response('', 404);
        } else {
            if ($request->ajax()) {
                return ArticleService::countLike(auth()->user()->id, $articleId, $this->currentLocaleId);
            }
        }
    }
}
