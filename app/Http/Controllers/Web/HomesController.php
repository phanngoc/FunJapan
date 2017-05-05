<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\ArticleService;

class HomesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->viewData['popularPost'] = ArticleService::getPopularPost($this->currentLocaleId);

        return view('web.home.index', $this->viewData);
    }
}
