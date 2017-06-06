@extends('layouts.admin.default')

@section('content')
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>{{ trans('admin/roles.label.user_role') }}</h5>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-5 m-b-xs">
                </div>
                <div class="col-sm-4 m-b-xs">
                </div>
                <div class="col-sm-3">
                    {{ Form::open(['action' => ['Admin\RolesController@getUsersRole'], 'method' => 'GET']) }}
                        <div class="input-group">
                            {{ Form::text('keyword', isset($input['keyword']) ? $input['keyword'] : null, [
                                'class' => 'input-sm form-control',
                                'placeholder' => trans('admin/roles.label.search'),
                            ]) }}
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    {{ trans('admin/roles.button.go') }}
                                </button>
                            </span>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="table-responsive table-striped">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('admin/roles.label.name') }}</th>
                            <th>{{ trans('admin/roles.label.email') }}</th>
                            <th>{{ trans('admin/roles.label.role') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    {{ Form::select('role_id', $roles, $user->role_id, [
                                        'class' => 'form-control change-role',
                                        'data-url' => action('Admin\RolesController@postUsersRole'),
                                        'data-user-id' => $user->id,
                                    ]) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <span class="label label-warning">{{ trans('roles.label.no_users') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pull-right">
                    {{ $users->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
    {!! Html::script('assets/admin/js/role.js') !!}
@endsection
