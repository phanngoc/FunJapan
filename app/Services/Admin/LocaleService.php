<?php

namespace App\Services\Admin;

use App\Models\Locale;

class LocaleService extends BaseService
{
    public static function getAllLocales()
    {
        return Locale::pluck('name', 'id')->all();
    }
}