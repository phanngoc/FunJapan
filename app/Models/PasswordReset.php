<?php

namespace App\Models;

class PasswordReset
{
    protected $fillable = [
        'email',
        'token',
        'is_active',
        'user_id',
    ];
}
