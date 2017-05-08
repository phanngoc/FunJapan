@extends('layouts/default_toppage')

@section('content')
    @include('web.includes._recommended_articles')
    @include('web.includes._articles_ranking')
    <div class="main-content">
        <div class="row gutter-32">
            <div class="col-md-70 main-column">
                <!-- MAIN -->
                <div class="list-group article-cards">
                    <div class="list-group-header">
                        <p class="list-group-title">{{ trans('web/top_page.new_post') }}</p>
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
