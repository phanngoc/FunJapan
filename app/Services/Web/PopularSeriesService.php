<?php
namespace App\Services\Web;

use App\Models\PopularSeries;

class PopularSeriesService
{
    public static function getPopularSeries($localeId)
    {
        $popularSeries = PopularSeries::where('locale_id', $localeId)->get();

        return $popularSeries;
    }
}
