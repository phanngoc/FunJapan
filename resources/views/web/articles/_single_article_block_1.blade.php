<div class="first-block">
    <a href="{{ action('Web\ArticlesController@show', ['id' => $article['id']]) }}">
        <div class="img-card first-block-img">
            <img src="{{ $article['photo'] }}">
            <p class="card-title"><span>{{ $article['locale']->title }}</span> </p>
            <p class="card-title-sm"><span>{{ $article['locale']->title }}</span></p>
        </div>
    </a>
</div>
