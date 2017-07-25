<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\Admin\BannerSettingService;
use App\Services\Admin\ArticleService;
use App\Services\Web\OmikujiService;
use App\Models\Omikuji;
use Carbon\Carbon;

class OmikujisController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->viewData['banners'] = BannerSettingService::getBannerViaLocale($this->currentLocaleId);
    }

    public function index()
    {
        // select default omikuji for show in web
        $omikuji = Omikuji::orderBy('created_at', 'ASC')
            ->where('locale_id', $this->currentLocaleId)
            ->where('start_time', '<=', Carbon::now())
            ->where(function ($query) {
                $query->whereNull('end_time')
                ->orWhere('end_time', '>=', Carbon::now());
            })
            ->first();

        if ($omikuji) {
            if ($omikuji->status == 'Running') {
                $this->viewData['remainingTime'] = OmikujiService::getRecoverTime($omikuji->id);
                $this->viewData['omikuji'] = $omikuji;

                return view('web.omikujis.' . $this->currentLocale . '.index', $this->viewData);
            }
        }

        return view('web.omikujis.' . $this->currentLocale . '.error', $this->viewData);
    }

    public function create(Request $request)
    {
        if (auth()->check()) {
            if (!OmikujiService::getRecoverTime($request['omikujiId'])) {
                $omikujiItemId = OmikujiService::getRandomItem($request['omikujiId']);
                if ($omikujiItemId) {
                    $omikujiItem = OmikujiService::getOmikujiItem($omikujiItemId);
                    if (OmikujiService::create($request, $omikujiItem->point)) {
                        $this->viewData['omikujiItem'] = $omikujiItem;
                        return view('web.omikujis.' . $this->currentLocale . '.showPoint', $this->viewData);
                    }
                }
            }
        }

        return redirect()->back();
    }
}
