@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="col-lg-8">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>{{ trans('admin/roles.label.edit') }}</h5>
        </div>
        <div class="ibox-content">
            {{ Form::open(['action' => ['Admin\RolesController@update', $role->id], 'method' => 'PUT', 'class' => 'form-inline']) }}
                <div class="form-group">
                    {{ Form::label('title', trans('admin/roles.label.title'), ['class' => 'sr-only']) }}
                    {{ Form::text('title', $role->title, ['placeholder'=> trans('admin/roles.label.title'), 'class' => 'form-control']) }}
                </div>
                <div class="checkbox m-r-xs">
                    {{ Form::checkbox('access_admin', 1, $role->access_admin) }}
                    {{ Form::label('access_admin', trans('admin/roles.label.access_admin')) }}
                </div>
                {{ Form::submit(trans('admin/roles.button.submit'), ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
