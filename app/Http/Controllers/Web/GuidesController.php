<?php

namespace App\Http\Controllers\Web;

use App\Services\Admin\ArticleService;

class GuidesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function about()
    {
        $this->viewData['popularPost'] = ArticleService::getPopularPost($this->currentLocaleId);

        return view('web.guide.' . $this->currentLocale . '.about', $this->viewData);
    }

    public function footPrint()
    {
        $this->viewData['popularPost'] = ArticleService::getPopularPost($this->currentLocaleId);

        return view('web.guide.' . $this->currentLocale . '.footprint', $this->viewData);
    }
}
