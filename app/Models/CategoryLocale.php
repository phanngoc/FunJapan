<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryLocale extends BaseModel
{

    protected $table = 'category_locales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'category_id',
        'name',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }
}
