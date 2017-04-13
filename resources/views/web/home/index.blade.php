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
                        <p class="list-group-title">NEW POST</p>
                    </div>
                    <div class="list-infinity">
                        <div class="list-group-article">
                            <div class="row gutter-16">
                                @include('web.includes._single_article')
                                @include('web.includes._single_article')
                            </div>
                        </div>
                        <div class="list-group-article">
                            <div class="row gutter-16">
                                @include('web.includes._single_article')
                                @include('web.includes._single_article')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- EOF MAIN -->
            </div>
            <div class="col-md-30 sidebar">
                @include('web.includes._side_bar_toppage')
            </div>
        </div>
    </div>
@endsection
