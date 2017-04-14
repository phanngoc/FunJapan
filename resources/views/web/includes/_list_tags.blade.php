<!-- TAGS -->
<div class="detail-tags">
    <ul class="tags">
        @foreach ($listTags as $listTag)
            <li class="hot-tag">
                <a href="#">
                    <span class="hashtag"># </span>{{ isset($listTag->tag) ? $listTag->tag->name : '' }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
<!-- EOF TAGS -->