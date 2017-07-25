<div class="col-md-6">
    <!-- CARD_ITEM -->
    <div class="list-group-item article-card-item">
        <a href="{{ action('Web\ArticlesController@show', ['id' => $article->article_id]) }}">
            <div class="img-card">
                <div class="article-card-item__thumbnail">
                    <img src="{{ $article->url_photo }}">
                </div>
            </div>
        </a>
        <div class="article-card-item__info">
            <p class="article-card-item__title" style="background-color: {{ $article->title_bg_color ?: 'none' }}">
                <span>{{ $article->title }}</span>
            </p>
            <div class="article-card-item__extra">
                <div class="article-card-item__engagement">
                    <p class="article-card-item__category">
                        <img class="category-icon" src="{{ $article->category->iconUrls['normal'] }}" />
                        {{ $article->category->name }} / {{ $article->category->short_name }}
                        <span class="verticle-bar">|</span>
                    </p>
                    <!-- ENGAGEMENT -->
                    <ul class="engagement">
                        <li>
                            <a class="engagement-favorite"
                                href="{{ action('Web\ArticlesController@show', ['id' => $article->article_id]) }}">
                                <i class="fa fa-heart"></i>
                            </a>
                            <span class="engagement-count">{{ $article->like_count }}</span>
                            <span>{{ trans('web/top_page.favorites') }}</span>
                        </li>
                        <li>
                            <a class="engagement-comment"
                                href="{{ action('Web\ArticlesController@show', ['id' => $article->article_id]) }}#comment-area-desktop">
                                <i class="fa fa-comment"></i>
                            </a>
                            <span class="engagement-count">{{ $article->comment_count }}</span>
                            <span>{{ trans('web/top_page.comments') }}</span>
                        </li>
                        <li>
                            <a class="engagement-share"
                                href="{{ action('Web\ArticlesController@show', ['id' => $article->article_id]) }}">
                                <i class="fa fa-share-alt"></i>
                            </a>
                            <span class="engagement-count">{{ $article->share_count }}</span>
                            <span>{{ trans('web/top_page.shares') }}</span>
                        </li>
                    </ul>
                    <!-- EOF ENGAGEMENT -->
                </div>

                <!-- TAGS -->
                <div class="article-card-item__tags">
                    @if ($article->articleTags->count())
                        <ul>
                            @foreach ($article->articleTags(config('limitation.tags.single_artile'), false)->get() as $articleTag)
                            <li class="hot-tag">
                                <a href="{{ action('Web\TagsController@show', ['name' => $articleTag->tag->name]) }}">
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
