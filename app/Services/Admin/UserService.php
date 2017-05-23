<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Role;

class UserService extends BaseService
{
    public static function getUsers($keyword = null, $limit = 20)
    {
        $users = User::with('role');

        if ($keyword) {
            $keyword = escape_like($keyword);
            $users = $users->where(function ($query) use ($keyword) {
                return $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%");
            });
        }

        return $users->paginate($limit);
    }

    public static function changeRole($input)
    {
        $user = User::find($input['userId']);

        if ($user) {
            return $user->update(['role_id' => $input['roleId']]);
        }

        return false;
    }
}
