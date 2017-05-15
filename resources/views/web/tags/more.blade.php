@for ($i = 0; $i < count($articles); $i+=2)
    <div class="list-group-article">
        <div class="row gutter-16">
            @php
                $article = $articles[$i];
            @endphp
            @include('web.tags._single_article')

            @if (isset($articles[$i + 1]))
                @php
                    $article = $articles[$i+1];
                @endphp
                @include('web.tags._single_article')
            @endif
        </div>
    </div>
@endfor
