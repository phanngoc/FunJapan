<!-- ARTICLE RANKING -->
@if($checkDisplay)
    <div class="article-ranking">
        <div class="row gutter-10">
            <div class="col-md-55">
                <div class="first-ranking">
                    @foreach($articleRanks as $articleRank)
                        @if (isset($articleRank->rank) && $articleRank->rank == 1 && isset($articleRank->articleLocale))
                            <a href="{{ action ('Web\ArticlesController@show', ['id' => $articleRank->articleLocale->article_id]) }}">
                                <div class="img-card first-ranking-img">
                                    <img src="{{ $articleRank->articleLocale->thumbnail_urls['original'] }}">
                                    <p class="card-title"><span>{{ $articleRank->articleLocale->title }}</span> </p>
                                    <p class="card-title-sm"><span>{{ $articleRank->articleLocale->title }}  </span></p>
                                    <p class="first-ranking-num">
                                        <span class="no">No</span><span class="dot">.</span><span class="number-1"> {{ $articleRank->rank }}</span>
                                    </p>
                                    <div class="triangle-bottomright-1"></div>
                                </div>
                                <div class="first-ranking-info">
                                    <p class="first-ranking-topic"><img src="{{ $articleRank->articleLocale->category->iconUrls['normal'] }}"> {{ $articleRank->articleLocale->category->name }}</p>
                                    <p class="first-ranking-des">
                                        {{ $articleRank->articleLocale->summary }}
                                    </p>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-45">
                <div class="row gutter-10">
                    <div class="col-xs-6">
                        @foreach($articleRanks as $articleRank)
                            @if (isset($articleRank->rank) && $articleRank->rank % 2 == 0 && isset($articleRank->articleLocale))
                                <div class="rest-ranking">
                                    <a href="{{ action ('Web\ArticlesController@show', ['id' => $articleRank->articleLocale->article_id]) }}">
                                        <div class="img-card list-group-ranking-item">
                                            <img src="{{ $articleRank->articleLocale->thumbnail_urls['original'] }}">
                                            <p class="card-title"><span>{{ $articleRank->articleLocale->title }}</span> </p>
                                            <p class="card-title-sm"><span>{{ $articleRank->articleLocale->title }}</span></p>
                                            <p class="rest-ranking-num">
                                                .{{ $articleRank->rank }}
                                            </p>
                                            <div class="triangle-bottomright-rest"></div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-xs-6">
                        @foreach($articleRanks as $articleRank)
                            @if (isset($articleRank->rank) && $articleRank->rank %2 == 1 && $articleRank->rank != 1 && isset($articleRank->articleLocale))
                                <div class="rest-ranking">
                                    <a href="{{ action ('Web\ArticlesController@show', ['id' => $articleRank->articleLocale->article_id]) }}">
                                        <div class="img-card list-group-ranking-item">
                                            <img src="{{ $articleRank->articleLocale->thumbnail_urls['original'] }}">
                                            <p class="card-title"><span>{{ $articleRank->articleLocale->title }}</span> </p>
                                            <p class="card-title-sm"><span>{{ $articleRank->articleLocale->title }}</span></p>
                                            <p class="rest-ranking-num">
                                                .{{ $articleRank->rank }}
                                            </p>
                                            <div class="triangle-bottomright-rest"></div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if (count($articleRanks))
                    <div class="vote-button">
                        <p class="text-center">
                            <a class="btn btn-default" role="button" href="#" target="_blank">
                                <span><i class="fa fa-heart"></i> Vote for your favorite article</span>
                            </a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
<!-- EOF ARTICLE RANKING -->