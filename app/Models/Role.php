<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseModel
{
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'access_admin',
    ];

    protected $appends = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($role) {
            User::where('role_id', $role->id)
                ->update(['role_id' => null]);
        });
    }

    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }

    public function hasDefinePrivilege($permission)
    {
        $permissions = $this->permissions->pluck('permission')->toArray();

        return in_array($permission, $permissions);
    }

    public function isAccessAdmin()
    {
        return $this->access_admin;
    }
}
