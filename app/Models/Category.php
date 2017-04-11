<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoryLocales()
    {
        return $this->hasMany(CategoryLocale::class);
    }
}
