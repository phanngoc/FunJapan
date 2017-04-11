<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Religion extends BaseModel
{

    protected $table = 'religions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place_holder',
    ];

    public function religionLocales()
    {
        return $this->hasMany(ReligionLocale::class);
    }
}
