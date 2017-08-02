<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\ArticleService as AdminArticleService;
use App\Services\Web\ArticleService as WebArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->viewData['newArticles'] = WebArticleService::getNewArticles(
            $this->currentLocaleId,
            config('limitation.new_post.per_page')
        );
        $this->viewData['myFeed'] = false;

        return view('web.home.index', $this->viewData);
    }

    public function getMyFeed(Request $request)
    {
        $this->viewData['newArticles'] = WebArticleService::getUserArticles(
            $this->currentLocaleId,
            Auth::user(),
            config('limitation.new_post.per_page')
        );
        $this->viewData['myFeed'] = true;

        return view('web.home.index', $this->viewData);
    }

    public function error()
    {
        return view('web.errors.404', $this->viewData);
    }
}
