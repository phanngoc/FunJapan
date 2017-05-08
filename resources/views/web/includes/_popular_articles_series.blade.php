<!-- POPULAR POST -->
<div class="popular-list">
    <ul class="nav popular-tabs">
        @if ($popularPost->count())
            <li class="active">
                <a data-toggle="tab" href="#popular-posts">POPULAR POSTS</a>
            </li>
        @endif
        <li class="{{ !$popularPost->count() ? 'active' : '' }}">
            <a data-toggle="tab" href="#popular-series">POPULAR SERIES</a>
        </li>
    </ul>
    <div class="tab-content">
      <!-- POPULAR POSTS -->
        @if ($popularPost->count())
            <div id="popular-posts" class="list-group tab-pane fade in active">
                <div class="list-group-popular-post">
                    @foreach ($popularPost as $post)
                        <div class="row">
                            <div class="col-xs-12">
                            <div class="list-group-item">
                                <div class="row gutter-12">
                                    <div class="col-md-39 pp-item-thumbnail">
                                      <a href="{{ action('Web\ArticlesController@show', ['id' => $post->article_id]) }}">
                                        <img class="img-thumbnail" src="{{ $post->thumbnail_urls['small'] }}">
                                      </a>
                                    </div>
                                    <div class="col-md-61">
                                        <div class="pp-item-info">
                                            <p class="pp-item-title">
                                                <a href="#">{{ $post->getShortTitle() }}</a>
                                            </p>
                                            <div class="loader-engagement"></div>
                                        </div>
                                    </div>
                                </div>
                                <img class="pp-icon" src="{{ $post->article->category->icon ? : '' }}">
                            </div>
                        </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    <!-- EOF POPULAR POSTS -->

    <!-- POPULAR SERIES -->
    <div id="popular-series" class="list-group tab-pane fade {{ !$popularPost->count() ? 'in active' : '' }}">
      <div class="list-group-popular-series">
        <div class="row">
          <div class="col-xs-12">
            <div class="list-group-item">
              <div class="row">
                <div class="col-xs-4 col-sm-5">
                  <a href="#">
                    <img src="https://indonesia.fun-japan.jp/~/media/Mpf/Website/Guide/ArticleSeries/reward.ashx" class="img-thumbnail">
                  </a>
                </div>
                <div class="col-xs-8 col-sm-7">
                  <p class="pp-item-title">
                    <a href="#">You will earn FP, and join present campaign program.</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="list-group-item">
              <div class="row">
                <div class="col-xs-4 col-sm-5">
                  <a href="#">
                    <img src="https://indonesia.fun-japan.jp/~/media/Mpf/Website/Guide/ArticleSeries/Personality.ashx" class="img-thumbnail">
                  </a>
                </div>
                <div class="col-xs-8 col-sm-7">
                  <p class="pp-item-title">
                    <a href="#">The test will give your idea about what it means to be you!</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="list-group-item">
              <div class="row">
                <div class="col-xs-4 col-sm-5">
                  <a href="#">
                    <img src="https://indonesia.fun-japan.jp/~/media/Mpf/Website/Guide/ArticleSeries/words.ashx" class="img-thumbnail">
                  </a>
                </div>
                <div class="col-xs-8 col-sm-7">
                  <p class="pp-item-title">
                    <a href="#">If you're interested in Japanese language, you'll like this series!</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="list-group-item">
              <div class="row">
                <div class="col-xs-4 col-sm-5">
                  <a href="#">
                    <img src="https://indonesia.fun-japan.jp/~/media/Mpf/Website/Guide/ArticleSeries/FJ_Photos.ashx" class="img-thumbnail">
                  </a>
                </div>
                <div class="col-xs-8 col-sm-7">
                  <p class="pp-item-title">
                    <a href="#">Upload fun photos and see who will gain many favorites.</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- EOF SERIES -->
  </div>
</div>
<!-- EOF POPULAR POST -->