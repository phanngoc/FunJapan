<?php

namespace App\Services\Admin;

use App\Models\Locale;

class LocaleService extends BaseService
{
    public static function getAllLocales()
    {
        return Locale::orderBy('name')->pluck('name', 'id')->all();
    }
}
