<div class="second-block">
    <a href="{{ action('Web\ArticlesController@show', ['id' => $article['id']]) }}">
        <div class="img-card second-block-img">
            <img src="{{ $article['locale']->thumbnail_urls['normal_'] }}">
            <p class="card-title"><span>{{ isset($article['locale']) ? $article['locale']->title : '' }}</span> </p>
            <p class="card-title-sm"><span>{{ isset($article['locale']) ? $article['locale']->title : '' }}</span></p>
        </div>
    </a>
</div>
