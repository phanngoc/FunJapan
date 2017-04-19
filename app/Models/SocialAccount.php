<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SocialAccount extends Authenticatable
{
    protected $fillable = [
        'provider_user_id',
        'provider',
        'user_id',
    ];

    public static function getSocial($socialId, $provider = 1)
    {
        return self::where('provider_user_id', $socialId)
            ->where('provider', $provider)
            ->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
