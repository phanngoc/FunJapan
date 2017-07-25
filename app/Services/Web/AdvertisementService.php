<?php

namespace App\Services\Web;

use App\Models\Advertisement;
use Carbon\Carbon;
use DB;

class AdvertisementService
{
    public static function getAdvertisement($localeIso)
    {
        $toDay = Carbon::today(config('app.admin_timezone'))->toDateString();

        return Advertisement::where('start_date', '<=', $toDay)
            ->where('end_date', '>=', $toDay)
            ->where('is_not_publish', false)
            ->where('locale_id', function ($query) use ($localeIso) {
                $query->select('id')
                    ->from('locales')
                    ->where('iso_code', $localeIso);
            })->first();
    }
}
