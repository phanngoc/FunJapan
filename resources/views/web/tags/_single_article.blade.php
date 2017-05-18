<div class="col-md-6">
  <!-- CARD_ITEM -->
  <div class="list-group-item list-group-item-cards">
    @php
      if (!Auth::check() && $article->articleLocale->is_member_only) {
        $url = route('login');
      } else {
        $url = route('article_detail', $article->article->id);
      }
    @endphp
    <a href="{{ $url }}">
      <div class="img-card card-item">
          <img src="{{ asset($article->articleLocale->thumbnail_urls['normal']) }}">
          <p class="card-title"><span>{{$article->articleLocale->title}}</span> </p>
          <p class="card-title-sm"><span>{{$article->articleLocale->title}}</span></p>
      </div>
    </a>

    <div class="article-info">
      <div class="article-summary">
        <div class="article-engagement">
          <p class="article-category"><img class="category-icon" src="{{ asset($article->article->category->icon_urls['normal']) }}" />{{$article->article->category->name}} <span class="verticle-bar">|</span></p>
          <!-- ENGAGEMENT -->
          <ul class="engagement">
              <li>
                <a class="engagement-favorite" href="{{ $url }}">
                  <i class="fa fa-heart"></i>
                </a>
                <span class="engagement-count">
                  {{ $article->articleLocale->like_count }}
                </span>
              </li>

              <li>
                <a class="engagement-comment" href="{{ $url . '#comment-area' }}">
                  <i class="fa fa-comment"></i>
                </a>
                <span class="engagement-count">
                  {{ $article->articleLocale->comment_count }}
                </span>
              </li>

              <li>
                <a class="engagement-share" href="{{ $url }}">
                  <i class="fa fa-share-alt"></i>
                </a>
                <span class="engagement-count">
                  {{ $article->articleLocale->share_count }}
                </span>
              </li>
          </ul>
          <!-- EOF ENGAGEMENT -->
        </div>
        <!-- TAGS -->
        <div class="article-tags">
          <ul>
            @foreach ($article->articleLocale->tags as $tag)
              <li class="hot-tag">
                <a href="{{ route('tag_detail', $tag->name) }}">
                  <span class="hashtag"># </span>{{$tag->name}}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
        <!-- EOF TAGS -->
      </div>
    </div>
  </div>
  <!-- EOF CARD_ITEM -->
</div>