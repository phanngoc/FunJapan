<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\ArticleService as AdminArticleService;
use App\Services\Web\ArticleService as WebArticleService;
use Illuminate\Http\Request;

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

        return view('web.home.index', $this->viewData);
    }

    public function error()
    {
        return view('web.errors.404', $this->viewData);
    }
}
