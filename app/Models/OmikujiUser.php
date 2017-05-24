<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmikujiUser extends BaseModel
{
    protected $table = 'omikuji_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'omikuji_play_time',
        'user_id',
        'omikuji_id',
    ];

    public function omikuji()
    {
        return $this->belongsTo(Omikuji::class);
    }
}
