<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\RoleService;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Gate;

class RolesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('permission', 'role.list'), 403, 'Unauthorized action.');

        $this->viewData['roles'] = Role::paginate(config('limitation.role.per_page'));

        return view('admin.roles.index', $this->viewData);
    }

    public function getChangePermission(Role $role)
    {
        abort_if(Gate::denies('permission', 'role.edit'), 403, 'Unauthorized action.');

        $this->viewData['role'] = $role;
        $this->viewData['rolePermissions'] = RoleService::getRolePermissions($role);
        $this->viewData['listPermissions'] = config('permissions.list');

        return view('admin.roles.change_permission', $this->viewData);
    }

    public function postChangePermission(Request $request, Role $role)
    {
        abort_if(Gate::denies('permission', 'role.edit'), 403, 'Unauthorized action.');

        $permissions = $request->get('permission') ?: [];

        if (RoleService::updateRolePermissions($role, $permissions)) {
            return redirect()->action('Admin\RolesController@getChangePermission', $role->id)
                ->with('message', trans('admin/roles.messages.update_success'));
        }

        return redirect()->action('Admin\RolesController@index')
            ->withErrors(['error' => trans('admin/roles.messages.update_fail')]);
    }

    public function create()
    {
        abort_if(Gate::denies('permission', 'role.add'), 403, 'Unauthorized action.');

        return view('admin.roles.create', $this->viewData);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('permission', 'role.add'), 403, 'Unauthorized action.');

        $input = $request->all();
        $validate = RoleService::validateCreate($input);

        if ($validate->fails()) {
            return redirect()->action('Admin\RolesController@create')
                ->withErrors($validate)
                ->withInput($input);
        }

        if (RoleService::create($input)) {
            return redirect()->action('Admin\RolesController@index')
                ->with('message', trans('admin/roles.messages.create_success'));
        }

        return redirect()->action('Admin\RolesController@index')
            ->withErrors(['error' => trans('admin/roles.messages.create_fail')]);
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('permission', 'role.edit'), 403, 'Unauthorized action.');

        $this->viewData['role'] = $role;

        return view('admin.roles.edit', $this->viewData);
    }

    public function update(Request $request, Role $role)
    {
        abort_if(Gate::denies('permission', 'role.edit'), 403, 'Unauthorized action.');

        $input = $request->all();
        $validate = RoleService::validateEdit($input, $role->id);

        if ($validate->fails()) {
            return redirect()->action('Admin\RolesController@edit', $role->id)
                ->withErrors($validate)
                ->withInput($input);
        }

        if (RoleService::update($input, $role)) {
            return redirect()->action('Admin\RolesController@edit', $role->id)
                ->with('message', trans('admin/roles.messages.update_success'));
        }

        return redirect()->action('Admin\RolesController@edit', $role->id)
            ->withErrors(['error' => trans('admin/roles.messages.update_fail')]);
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('permission', 'role.delete'), 403, 'Unauthorized action.');

        if ($role->delete()) {
            return [
                'success' => true,
                'message' => trans('admin/roles.messages.delete_success'),
            ];
        }

        return [
            'success' => false,
            'message' => trans('admin/roles.messages.delete_fail'),
        ];
    }

    public function getUsersRole(Request $request)
    {
        abort_if(Gate::denies('permission', 'role.change'), 403, 'Unauthorized action.');

        $input = $request->only('keyword');
        $this->viewData['users'] = UserService::getUsers($input['keyword'], config('limitation.role.per_page'));
        $this->viewData['input'] = $input;
        $this->viewData['roles'] = ['' => trans('admin/roles.label.no_role')] + Role::pluck('title', 'id')->toArray();

        return view('admin.roles.user_role', $this->viewData);
    }

    public function postUsersRole(Request $request)
    {
        abort_if(Gate::denies('permission', 'role.change'), 403, 'Unauthorized action.');

        $input = $request->input();

        if (UserService::changeRole($input)) {
            return [
                'success' => true,
                'message' => trans('admin/roles.messages.change_success'),
            ];
        }

        return [
            'success' => false,
            'message' => trans('admin/roles.messages.change_fail'),
        ];
    }
}
