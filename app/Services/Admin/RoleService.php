<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Log;
use App\Models\RolePermission;
use App\Models\Role;
use Carbon\Carbon;
use Validator;
use Exception;
use DB;

class RoleService extends BaseService
{
    public static function getRolePermissions($role)
    {
        return $role->permissions()->pluck('permission')->toArray();
    }

    public static function updateRolePermissions($role, $permissions)
    {
        DB::beginTransaction();
        try {
            $oldPermissions = $role->permissions()->pluck('permission')->toArray();
            $deletePermissions = array_diff($oldPermissions, $permissions);
            $newPermissions = array_diff($permissions, $oldPermissions);
            $role->permissions()->whereIn('permission', $deletePermissions)->delete();

            $rolePermissions = [];
            foreach ($newPermissions as $permission) {
                $rolePermissions[] = [
                    'role_id' => $role->id,
                    'permission' => $permission,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            if ($rolePermissions) {
                RolePermission::insert($rolePermissions);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollback();
            Log::debug($e);

            return false;
        }
    }

    public static function validateCreate($input)
    {
        $validationRules = [
            'title' => 'required|string|unique:roles,title',
        ];

        return Validator::make($input, $validationRules);
    }

    public static function create($input)
    {
        $input['access_admin'] = isset($input['access_admin']) ? $input['access_admin'] : 0;

        return Role::create($input);
    }

    public static function validateEdit($input, $id)
    {
        $validationRules = [
            'title' => 'required|string|unique:roles,title,' . $id,
        ];

        return Validator::make($input, $validationRules);
    }

    public static function update($input, $role)
    {
        $input['access_admin'] = isset($input['access_admin']) ? $input['access_admin'] : 0;

        return $role->update($input);
    }
}
