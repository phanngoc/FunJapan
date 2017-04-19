<?php
namespace App\Services\Web;

use App\Models\Locale;

class LocaleService
{
    public static function getAllLocale()
    {
        return Locale::getAll();
    }

    public static function getLocaleByIsoCode($isoCode)
    {
        return Locale::where('iso_code', $isoCode)->first();
    }
}
