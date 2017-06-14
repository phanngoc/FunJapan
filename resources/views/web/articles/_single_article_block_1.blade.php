<div class="first-block">
    <a href="{{ action('Web\ArticlesController@show', ['id' => $article['id']]) }}">
        <div class="img-card first-block-img">
            <div class="card-thumbnail">
                <img src="{{ $article['locale']->thumbnail_urls['larger'] }}">
            </div>
            <p class="card-title"><span>{{ isset($article['locale']) ? $article['locale']->title : '' }}</span> </p>
        </div>
    </a>
</div>
