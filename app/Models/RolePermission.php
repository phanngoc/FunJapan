<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends BaseModel
{
    protected $table = 'role_permissions';

    protected $guarded = ['id'];

    protected $fillable = [
        'role_id',
        'permission',
    ];
}
