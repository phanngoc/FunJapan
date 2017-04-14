<?php

namespace App\Models;

class Locale extends BaseModel
{
    protected $table = 'locales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso_code',
        'name',
    ];

    public static function getAll()
    {
        $locales = self::all();
        $result = [];

        foreach ($locales as $value) {
            $result[$value->iso_code] = $value->toArray();
        }

        return $result;
    }
}
