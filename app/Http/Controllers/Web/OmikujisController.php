<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\Admin\BannerSettingService;
use App\Services\Admin\ArticleService;
use App\Services\Web\OmikujiService;
use App\Models\Omikuji;

class OmikujisController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->viewData['popularPost'] = ArticleService::getPopularPost($this->currentLocaleId);
        $this->viewData['banners'] = BannerSettingService::getBannerViaLocale($this->currentLocaleId);
    }

    public function index()
    {
        // select default omikuji for show in web
        $omikuji = Omikuji::orderBy('created_at', 'ASC')->first();
        if ($omikuji) {
            $this->viewData['remainingTime'] = OmikujiService::getRecoverTime($omikuji->id);
            $this->viewData['omikuji'] = $omikuji;

            return view('web.omikujis.' . $this->currentLocale . '.index', $this->viewData);
        }

        return redirect()->back();
    }

    public function create(Request $request)
    {
        if (auth()->check()) {
            if (!OmikujiService::getRecoverTime($request['omikujiId'])) {
                $omikujiItemId = OmikujiService::getRandomItem($request['omikujiId']);
                if ($omikujiItemId) {
                    if (OmikujiService::create($request)) {
                        $this->viewData['omikujiItem'] = OmikujiService::getOmikujiItem($omikujiItemId);

                        return view('web.omikujis.' . $this->currentLocale . '.showPoint', $this->viewData);
                    }
                }
            }
        }

        return redirect()->back();
    }
}
