<?php

namespace App\Models;

class JmbCity extends BaseModel
{
    protected $table = 'jmb_cities';

    public function jmbCountry()
    {
        return $this->belongsTo(JmbCountry::class, 'jmb_country_id');
    }
}
