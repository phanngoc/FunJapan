<?php
namespace App\Services\Admin;

use App\Models\TagLocale;

class TagLocaleService extends BaseService
{
    public static function create($tagLocale)
    {
        return TagLocale::create($tagLocale);
    }
}
