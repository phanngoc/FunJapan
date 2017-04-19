<article>
    @include('web.includes._breadcrumbs')
    <div class="detail-engagement">
        <ul class="detail-favorite">
            <li>
                <a class="engagement-favorite" data-mpf-article-id="66e2b2081c4a40218c5ff119c68f984b" href="#">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </a>
                <span class="engagement-count">{{ $articleLocale->like_count }}</span>
            </li>
            <li>
                <span class="verticle-slash">|</span>
            </li>
            <li>
                <span class="posted-date">
                    <time datetime="2016-11-06">
                        {{ $articleLocale->published_at->toFormattedDateString() }}
                    </time>
                </span>
            </li>
        </ul>
    </div>
    @include('web.includes._social_share')
    <!-- Article Main -->
    <div class="article-body clearfix">
        {!! $articleLocale->content !!}
    </div>
    <!-- Engagement 2 -->
    <div class="detail-engagement">
        <ul class="detail-favorite">
            <li>
                <a class="engagement-favorite" data-mpf-article-id="66e2b2081c4a40218c5ff119c68f984b" href="#">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </a>
                <span class="engagement-count">{{ $articleLocale->like_count }}</span>
            </li>
            <li>
                <span class="verticle-slash">|</span>
            </li>
            <li>
                <span class="post-text">{{ trans('web/global.posted_by') }} </span><span class="post-author">
                    {{ isset($articleLocale->article->user) ? $articleLocale->article->user->name : '' }}
                </span>
            </li>
        </ul>
    </div>
    @include('web.includes._social_share')
    @if (isset($articleLocale->article->articleTags))
        @include('web.includes._list_tags', [
            'listTags' => $articleLocale->article->articleTags
        ])
    @endif
</article>
