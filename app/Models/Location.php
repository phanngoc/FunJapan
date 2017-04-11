<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends BaseModel
{

    protected $table = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'name',
    ];

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }
}
