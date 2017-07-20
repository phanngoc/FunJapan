@extends('layouts/default_toppage')

@section('content')
    {{-- @include('web.includes._recommended_articles', ['recommendArticles' => $recommendArticles]) --}}
    {{-- @include('web.includes._articles_ranking') --}}
    <div class="main-content">
        <div class="row gutter-32">
            <div class="col-md-70 main-column">
                <!-- MAIN -->
                <div class="list-group list-group--card">
                    <div class="list-group__header">
                        <a class="list-group__switch" href="#">
                            <i class="zmdi zmdi-globe"></i>
                            <span>{{ trans('web/top_page.new_post') }}</span>
                        </a>
                        <a class="list-group__switch" href="#">
                            <i class="zmdi zmdi-layers"></i>
                            <span>{{ trans('web/top_page.my_post') }}</span>
                        </a>
                    </div>
                    @include('web.includes._list_new_posts', ['newArticles' => $newArticles])
                </div>
                <!-- EOF MAIN -->
            </div>
            <div class="col-md-30 sidebar">
                @include('web.includes._side_bar_toppage')
            </div>
        </div>
    </div>
@endsection
