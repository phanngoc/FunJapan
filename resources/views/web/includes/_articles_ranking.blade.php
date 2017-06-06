<!-- ARTICLE RANKING -->
@if($checkDisplay)
    <div class="article-ranking">
        <div class="row gutter-10">
            <div class="col-md-55">
                <div class="first-ranking">
                    @foreach($rank1 as $rank)
                        <a href="{{ action ('Web\ArticlesController@show', ['id' => $rank->articleLocale->article_id]) }}">
                            <div class="img-card first-ranking-img">
                                <img src="{{ $rank->articleLocale->thumbnail_urls['original'] }}">
                                <p class="card-title"><span>{{ $rank->articleLocale->getShortTitle() }}</span> </p>
                                <p class="card-title-sm"><span>{{ $rank->articleLocale->getShortTitle() }}  </span></p>
                                <p class="first-ranking-num">
                                    <span class="no">No</span><span class="dot">.</span><span class="number-1"> {{ $rank->rank }}</span>
                                </p>
                                <div class="triangle-bottomright-1"></div>
                            </div>
                            <div class="first-ranking-info">
                                <p class="first-ranking-topic"><img src="{{ $rank->articleLocale->category->iconUrls['normal'] }}"> {{ $rank->articleLocale->category->name }} / {{ $rank->articleLocale->category->short_name }}</p>
                                <p class="first-ranking-des">
                                    {{ $rank->articleLocale->getShortSummary() }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-45">
                <div class="row gutter-10">
                    <div class="col-xs-6">
                        @foreach($articleRanks as $key => $articleRank)
                            @if ($key % 2 == 0)
                                <div class="rest-ranking">
                                    <a href="{{ action ('Web\ArticlesController@show', ['id' => $articleRank->articleLocale->article_id]) }}">
                                        <div class="img-card list-group-ranking-item">
                                            <img src="{{ $articleRank->articleLocale->thumbnail_urls['original'] }}">
                                            <p class="card-title"><span>{{ $articleRank->articleLocale->getShortTitle() }}</span> </p>
                                            <p class="card-title-sm"><span>{{ $articleRank->articleLocale->getShortTitle() }}</span></p>
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
                        @foreach($articleRanks as $key => $articleRank)
                            @if ($key % 2 != 0)
                                <div class="rest-ranking">
                                    <a href="{{ action ('Web\ArticlesController@show', ['id' => $articleRank->articleLocale->article_id]) }}">
                                        <div class="img-card list-group-ranking-item">
                                            <img src="{{ $articleRank->articleLocale->thumbnail_urls['original'] }}">
                                            <p class="card-title"><span>{{ $articleRank->articleLocale->getShortTitle() }}</span> </p>
                                            <p class="card-title-sm"><span>{{ $articleRank->articleLocale->getShortTitle() }}</span></p>
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
            </div>
        </div>
    </div>
@endif
<!-- EOF ARTICLE RANKING -->