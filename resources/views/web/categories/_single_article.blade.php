<div class="col-md-6">
    <!-- CARD_ITEM -->
    <div class="list-group-item list-group-item-cards">
        @php
            if (!Auth::check() && $article->is_member_only) {
                $url = route('login');
            } else {
                $url = route('article_detail', $article->article_id);
            }
        @endphp
        <a href="{{ $url }}">
            <div class="img-card card-item">
                <div class="card-thumbnail">
                    <img src="{{ asset($article->thumbnail_urls['normal']) }}">
                </div>
                <p class="card-title"><span>{{ $article->title }}</span> </p>
            </div>
        </a>
        <div class="article-info">
            <div class="article-summary">
                <div class="article-engagement">
                    <p class="article-category">
                        <img class="category-icon" src="{{ asset($category->icon_urls['normal']) }}" />
                        {{ $category->name }} / {{ $category->short_name }}
                        <span class="verticle-bar">|</span>
                    </p>
                    <!-- ENGAGEMENT -->
                    <ul class="engagement">
                        <li>
                            <a class="engagement-favorite" href="{{ $url }}">
                                <i class="fa fa-heart"></i>
                            </a>
                            <span class="engagement-count">
                                {{ $article->like_count }}
                            </span>
                        </li>

                        <li>
                            <a class="engagement-comment" href="{{ $url . '#comment-area-desktop' }}">
                                <i class="fa fa-comment"></i>
                            </a>
                            <span class="engagement-count">
                                {{ $article->comment_count }}
                            </span>
                        </li>

                        <li>
                            <a class="engagement-share" href="{{ $url }}">
                                <i class="fa fa-share-alt"></i>
                            </a>
                            <span class="engagement-count">
                                {{ $article->share_count }}
                            </span>
                        </li>
                    </ul>
                    <!-- EOF ENGAGEMENT -->
                </div>
                <!-- TAGS -->
                <div class="article-tags">
                    <ul>
                        @foreach ($article->articleTags(config('limitation.tags.single_artile'), false)->get() as $tag)
                            <li class="hot-tag">
                                <a href="{{ route('tag_detail', $tag->tag->name) }}">
                                    <span class="hashtag"># </span>{{ $tag->tag->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- EOF TAGS -->
            </div>
        </div>
    </div>
    <!-- EOF CARD_ITEM -->
</div>
