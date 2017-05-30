<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotTag extends BaseModel
{

    protected $table = 'hot_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'tag_id',
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
