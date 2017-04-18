<?php

namespace App\Models;

class PasswordReset extends BaseModel
{
    protected $table = 'password_resets';

    protected $primaryKey = 'token';

    public $incrementing = false;

    protected $fillable = [
        'email',
        'token',
        'is_active',
        'user_id',
    ];
}
