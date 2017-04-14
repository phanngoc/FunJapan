<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Web\LocaleService;
use Illuminate\Support\Facades\App;

class BaseController extends Controller
{
    protected $currentLocaleId;
    protected $currentLocale;

    public function __construct()
    {
        $currentLocale = LocaleService::getLocaleByIsoCode(App::getLocale());
        $this->currentLocaleId = $currentLocale->id;
        $this->currentLocale = $currentLocale->iso_code;
    }
}
