<?php

namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;
use App\Services\Web\LocaleService;
use App\Services\Web\MenuService;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $viewData;
    protected $currentLocaleId;
    protected $currentLocale;

    public function __construct()
    {
        $this->viewData = [];
        $currentLocale = LocaleService::getLocaleByIsoCode(App::getLocale());
        $this->currentLocaleId = $currentLocale->id;
        $this->currentLocale = $currentLocale->iso_code;
        $this->viewData['menu'] = MenuService::getMenu($currentLocale->id);
        $this->viewData['currentLocale'] = $currentLocale->iso_code;
    }
}
