<?php

namespace App\Models;

class JmbCountry extends BaseModel
{
    protected $table = 'jmb_countries';

    public function jmbCities()
    {
        return $this->hasMany(JmbCity::class, 'jmb_country_id', 'id');
    }
}
