<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuLocale extends BaseModel
{

    protected $table = 'menu_locales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'menu_id',
        'name',
    ];

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
