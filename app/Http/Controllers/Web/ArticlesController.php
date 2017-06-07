<?php

namespace App\Http\Controllers\Web;

use App\Events\ViewCountEvent;
use App\Services\Web\ArticleService;
use App\Services\Web\CommentService;
use App\Services\Web\CategoryService;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->viewData['title'] = trans('web/global.title');
    }

    public function show($id)
    {
        $article = ArticleService::getArticleDetail($id, $this->currentLocaleId);
        if (!$article) {
            return abort(404);
        }

        if (!auth()->check()
            && isset($article->locale->is_member_only)
            && $article->locale->is_member_only == 1) {
            return redirect()->action('Web\LoginController@showLoginForm');
        }

        if (isset($article->category)) {
            $this->viewData['categoryName'] = $article->category->name;
        } else {
            return view('web.articles.show', $this->viewData)->withErrors(trans('web/global.error'));
        }

        $this->viewData['nextArticleId'] = ArticleService::getNextArticleId(
            $article,
            $this->currentLocaleId
        );
        $this->viewData['article'] = $article;
        $this->viewData['title'] = trans('web/global.title', ['article_title' => ' - ' . $article->locale->title]);
        $this->viewData['photo'] = $article->photo;
        $this->viewData['comments'] = CommentService::lists(
            $article->locale->id,
            config('limitation.comment.per_page')
        );

        if ($article->type == config('article.type.photo')) {
            $this->viewData['postPhotos'] = ArticleService::getPostPhotosList(
                $article->id,
                $this->currentLocaleId,
                [],
                'created_desc',
                config('limitation.post_photo.per_page')
            );
        }

        if (auth()->check()) {
            $this->viewData['favorite'] = ArticleService::getFavoriteArticleDetails(
                auth()->user()->id,
                $article->id,
                $article->locale->id
            );
        }

        event(new ViewCountEvent($article->locale));

        return view('web.articles.show', $this->viewData);
    }

    public function countLike(Request $request, $articleId)
    {
        if (!auth()->check()) {
            return response('', 404);
        } else {
            if ($request->ajax()) {
                return ArticleService::countLike(auth()->user()->id, $articleId, $this->currentLocaleId);
            }
        }
    }

    public function countShare(Request $request, $articleId)
    {
        if ($request->ajax()) {
            return ArticleService::countShare($articleId, $this->currentLocaleId);
        }
    }
}
