<div class="list-infinity">
    @for ($i = 0; $i <= $newArticles->count(); $i += 2)
        <div class="list-group-article">
            <div class="row gutter-16">
                @if (isset($newArticles[$i]))
                    @include('web.includes._single_article', ['article' => $newArticles[$i]])
                @endif
                @if (isset($newArticles[$i + 1]))
                    @include('web.includes._single_article', ['article' => $newArticles[$i + 1]])
                @endif
            </div>
        </div>
    @endfor
    <div class="next-page list-group-article">
        @if ($newArticles->currentPage() < $newArticles->lastPage())
            <a href="{{ action('Web\HomesController@index', [ 'page' => $newArticles->currentPage() + 1]) }}"></a>
        @endif
    </div>
</div>
