<!-- TAGS -->
<div class="detail-tags">
    <ul class="tags">
        @foreach ($articleLocale->article->articleTags as $articleTag)
            @if ($articleTag->article_locale_id == $articleLocale->id && $articleTag->tag->status == 0)
                <li class="hot-tag">
                    <a href="{{ route('tag_detail', $articleTag->tag->name) }}">
                        <span class="hashtag"># </span>{{ $articleTag->tag->name }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
<!-- EOF TAGS -->