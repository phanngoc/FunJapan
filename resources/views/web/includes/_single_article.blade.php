<div class="col-md-6">
    <!-- CARD_ITEM -->
    <div class="list-group-item list-group-item-cards">
        <a href="{{ action('Web\ArticlesController@show', ['id' => $article->article_id]) }}">
            <div class="img-card card-item">
                <img src="{{ $article->thumbnail_urls['original'] }}">
                <p class="card-title"><span>{{ $article->title }}</span> </p>
                <p class="card-title-sm"><span>{{ $article->title }}</span></p>
            </div>
        </a>
        <div class="article-info">
            <div class="article-summary">
                <div class="article-engagement">
                    <p class="article-category">
                        <img class="category-icon" src="{{ $article->article->category->iconUrls['normal'] }}" />
                        {{ $article->article->category->name }}
                    </p>
                    <!-- ENGAGEMENT -->
                    <ul class="engagement">
                        <li>
                            <a class="engagement-favorite">
                                <i class="fa fa-heart"></i>
                            </a>
                            <span class="engagement-count">{{ $article->like_count }}</span>
                            <span>{{ trans('web/top_page.favorites') }}</span>
                        </li>
                        <li>
                            <a class="engagement-comment">
                                <i class="fa fa-comment"></i>
                            </a>
                            <span class="engagement-count">{{ $article->comment_count }}</span>
                            <span>{{ trans('web/top_page.comments') }}</span>
                        </li>
                        <li>
                            <a class="engagement-share">
                                <i class="fa fa-share-alt"></i>
                            </a>
                            <span class="engagement-count">{{ $article->share_count }}</span>
                            <span>{{ trans('web/top_page.shares') }}</span>
                        </li>
                    </ul>
                    <!-- EOF ENGAGEMENT -->
                </div>
                <!-- TAGS -->
                <div class="article-tags">
                    @if ($article->articleTags->count())
                        <ul>
                            @foreach ($article->articleTags as $articleTag)
                            <li class="hot-tag">
                                <a href="#">
                                    <span class="hashtag">#</span> {{ $articleTag->tag->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <!-- EOF TAGS -->
            </div>
        </div>
    </div>
    <!-- EOF CARD_ITEM -->
</div>
