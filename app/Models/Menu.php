<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends BaseModel
{

    protected $table = 'menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place_holder',
        'parent_id',
        'icon',
        'link',
    ];

    public function menuLocales()
    {
        return $this->hasMany(MenuLocale::class);
    }
}
