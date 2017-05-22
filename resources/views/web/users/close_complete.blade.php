@extends('layouts/default_toppage')

@section('style')

@endsection

@section('content')
    <div class="main-content">
        <div class="row gutter-32">
            <div class="col-md-70 main-column">
                <div>
                    <h3>{{ trans('web/user.close_page.title') }}</h3>
                    <div id="ContentWrapper">
                        <p>{{ trans('web/user.close_page.close_complete') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-30 sidebar">
                @include('web.includes._side_bar_toppage')
            </div>
        </div>
    </div>
@endsection
