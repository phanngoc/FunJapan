@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>{{ $role->title }}</h5>
        </div>
        <div class="ibox-content">
            {{ Form::open([
                'action' => ['Admin\RolesController@postChangePermission', $role->id],
                'method' => 'POST',
            ]) }}
                <div class="table-responsive table-striped">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/roles.label.permission') }}</th>
                                <th>{{ trans('admin/roles.label.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listPermissions as $key => $permissions)
                                <tr>
                                    <td>
                                        {{ Form::label('permission.' . $key, trans('admin/roles.permissions.' . $key),
                                            ['class' => 'control-label']) }}
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            @foreach($permissions as $permission)
                                                {{ Form::checkbox('permission[]', $permission, in_array($permission, $rolePermissions)) }}
                                                {{ $permission }}
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ Form::submit(trans('admin/roles.button.submit'), ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
