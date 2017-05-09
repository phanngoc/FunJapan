@extends('layouts/default_toppage')

@section('style')
    {{ Html::script('assets/js/web/infinite-scroll/jquery.infinitescroll.js') }}
    {{ Html::script('assets/js/web/category.js') }}
@endsection

@section('content')
    <div class="main-content">
        <div class="row gutter-32">
            <div class="col-md-70 main-column">
                <!-- MAIN -->
                <div class="list-group article-cards">
                    <div class="list-group-header">
                        <p class="list-group-title">{{$category->name}}</p>
                    </div>
                    <div class="list-infinity">
                        @include('web.categories.more')
                        <div class="next list-group-article">
                            @if ($articles->currentPage() < $articles->lastPage())
                                <a class="next-page" href="{{ route('index') . '?category=' . $category->short_name . '&page=' . ($articles->currentPage() + 1) }}"></a>
                            @endif
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
