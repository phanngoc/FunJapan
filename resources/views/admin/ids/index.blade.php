@extends('layouts.admin.default')

@section('style')
{!! Html::style('assets/admin/css/client.css') !!}
@endsection

@section('content')
    <ul class="nav nav-tabs" id="tabs">
        <li class="{{ isset($tab) ? ($tab == 'client' ? 'active' : '') : 'active' }}"><a data-toggle="tab" href="#client">{{ trans('admin/client.client_management') }}</a></li>
        <li class="{{ isset($tab) ? ($tab == 'author' ? 'active' : '') : '' }}"><a data-toggle="tab" href="#author">{{ trans('admin/client.author_management') }}</a></li>
        <li><a data-toggle="tab" href="#tag">{{ trans('admin/client.tag_management') }}</a></li>
    </ul>

    <div class="tab-content">
        <div id="client" class="tab-pane fade {{ isset($tab) ? ($tab == 'client' ? 'in active' : '') : 'in active' }}">
            @include('admin.clients.index')
        </div>
        <div id="author" class="tab-pane fade {{ isset($tab) ? ($tab == 'author' ? 'in active' : '') : '' }}">
            @include('admin.authors.index')
        </div>
        <div id="tag" class="tab-pane fade">
        </div>
    </div>
@endsection
@section('script')
    {!! Html::script('assets/admin/js/client.js') !!}
    {!! Html::script('assets/admin/js/author.js') !!}
    <script type="text/javascript">
        var labelUpdateSuccess = "{{ trans('admin/article.update_success') }}";
        var labelCreateSuccess = "{{ trans('admin/article.create_success') }}";
    </script>
@endsection