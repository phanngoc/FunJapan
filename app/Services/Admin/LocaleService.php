<?php

namespace App\Services\Admin;

use App\Models\Locale;

class LocaleService extends BaseService
{
    public static function getAllLocales()
    {
        return Locale::orderBy('name')->pluck('name', 'id')->all();
    }

    public static function getLocaleSort($order = 'ASC')
    {
        return Locale::orderBy('name', $order)->pluck('name', 'id')->toArray();
    }

    public static function getAllIsoCodeLocales()
    {
        return Locale::orderBy('iso_code')->pluck('iso_code', 'id')->all();
    }
}
