<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
