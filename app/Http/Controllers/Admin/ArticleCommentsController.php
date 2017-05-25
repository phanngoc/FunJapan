<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\LocaleService;
use App\Services\Admin\CommentService;

class ArticleCommentsController extends Controller
{
    public function index()
    {
        $this->viewData['locales'] = LocaleService::getLocaleSort();
        return view('admin.article_comment.index', $this->viewData);
    }

    public function getListArticleComments(Request $request)
    {
        $params = $request->all();
        $draw = $params['draw'];
        $tagsData = CommentService::list($params);
        $tagsData['draw'] = (int)$draw;

        return $tagsData;
    }

    public function create()
    {
        $this->viewData['locales'] = LocaleService::getLocaleSort();

        return view('admin.omikuji.create', $this->viewData);
    }

    public function destroy($id)
    {
        if (CommentService::delete($id)) {
            return redirect()->action('Admin\ArticleCommentsController@index')
                ->with(['message' => trans('admin/article_comment.delete_success')]);
        }

        return redirect()->action('Admin\ArticleCommentsController@index')
                ->withErrors(['errors' => trans('admin/article_comment.delete_error')]);
    }
}
