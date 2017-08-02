<!-- TAGS -->
<div class="detail-tags">
    <ul class="tags">
        @foreach ($articleLocale->article->articleTags as $articleTag)
            @if ($articleTag->article_locale_id == $articleLocale->id && $articleTag->tag->status == 0)
                @php
                    $tagLocale = $articleTag->tag->tagLocales($articleLocale->locale_id)->first()
                @endphp
                <li class="hot-tag">
                    <a href="{{ route('tag_detail', $tagLocale->name) }}">
                        <span class="hashtag"># </span>{{ $tagLocale->name }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
<!-- EOF TAGS -->