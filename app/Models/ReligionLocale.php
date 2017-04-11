<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReligionLocale extends BaseModel
{

    protected $table = 'religion_locales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'religion_id',
        'name',
    ];

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }
}
