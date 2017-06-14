<!-- RECOMMENDED_POSTS -->
@if ($recommendArticles->count())
<section class="regular slider">
    @foreach ($recommendArticles as $article)
        <div>
            <a href="{{ action('Web\ArticlesController@show', ['id' => $article->article_id]) }}">
                <div class="img-card slider-img">
                    <div class="card-thumbnail">
                        <img src="{{ $article->thumbnail_urls['normal'] }}">
                    </div>
                    <p class="card-title">
                        <span class="content">
                            {{ str_limit($article->title, config('limitation.recommended_article.title_limit')) }}
                        </span>
                    </p>
                </div>
            </a>
        </div>
    @endforeach
</section>
@endif
<!-- EOF RECOMMENDED_POSTS -->
