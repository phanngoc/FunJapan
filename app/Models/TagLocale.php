<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagLocale extends BaseModel
{
    protected $table = 'tag_locales';

    protected $fillable = [
        'tag_id',
        'name',
        'locale_id',
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
