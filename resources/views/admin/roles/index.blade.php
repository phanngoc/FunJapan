@extends('layouts.admin.default')

@section('content')
<div class="ibox-title">
    <h5>{{ trans('admin/roles.label.management') }}</h5>
</div>
<div class="ibox-content">
    <div class="table-responsive table-striped">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('admin/roles.label.title') }}</th>
                    <th>{{ trans('admin/roles.label.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr role="row">
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->title }}</td>
                        <td>
                            <a href="{{ action('Admin\RolesController@getChangePermission', $role->id) }}"
                                title="{{ trans('admin/roles.label.permission') }}">
                                <i class="fa fa-th-list"></i>
                            </a>
                            <a href="{{ action('Admin\RolesController@edit', $role->id) }}"
                                title="{{ trans('admin/roles.label.edit') }}">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="javascript:;" class="role-delete" data-id="{{ $role->id }}"
                                data-url="{{ action('Admin\RolesController@destroy', $role->id) }}"
                                data-message-confirm="{{ trans('admin/roles.messages.confirm_delete') }}"
                                data-title="{{ $role->title }}"
                                data-yes-confirm="{{ trans('admin/roles.button.yes') }}"
                                data-cancel-confirm="{{ trans('admin/roles.button.cancel') }}"
                                title="{{ trans('admin/roles.label.delete') }}">
                                <i class="fa fa-minus-circle"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <span class="label label-warning">{{ trans('admin/roles.label.no_role') }}</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pull-right">
            {{ $roles->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>
@stop

@section('script')
    {!! Html::script('assets/admin/js/role.js') !!}
@endsection
