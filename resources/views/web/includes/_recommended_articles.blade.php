<!-- RECOMMENDED_POSTS -->
@if ($recommendArticles->count())
<section class="regular slider">
    @foreach ($recommendArticles as $article)
        <div>
            <a href="{{ action('Web\ArticlesController@show', ['id' => $article->article_id]) }}">
                <div class="img-card slider-img">
                    <img src="{{ $article->thumbnail_urls['normal'] }}">
                    <p class="card-title"><span>{{ str_limit($article->title, config('limitation.recommended_article.title_limit')) }}</span> </p>
                    <p class="card-title-sm"><span>{{ str_limit($article->title, config('limitation.recommended_article.title_limit')) }}</span></p>
                </div>
            </a>
        </div>
    @endforeach
</section>
@endif
<!-- EOF RECOMMENDED_POSTS -->
