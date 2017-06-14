<!-- POPULAR POST -->
<div class="popular-list">
    <ul class="nav popular-tabs">
        @if ($popularPost->count())
            <li class="active">
                <a data-toggle="tab" href="#popular-posts">POPULAR POSTS</a>
            </li>
        @endif
        @if ($popularSeries->count())
            <li class="{{ !$popularPost->count() ? 'active' : '' }}">
                <a data-toggle="tab" href="#popular-series">POPULAR SERIES</a>
            </li>
        @endif
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
                                            <a href="{{ action('Web\ArticlesController@show', ['id' => $post->article_id]) }}">
                                                <p class="pp-item-title">{{ $post->getShortTitle() }}</p>
                                            </a>
                                            <div class="loader-engagement"></div>
                                        </div>
                                    </div>
                                </div>
                                <img class="pp-icon" src="{{ $post->article->category->icon_urls['normal'] ? : '' }}">
                            </div>
                        </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    <!-- EOF POPULAR POSTS -->

    <!-- POPULAR SERIES -->
    @if ($popularSeries->count() > 0)
        <div id="popular-series" class="list-group tab-pane fade {{ !$popularPost->count() ? 'in active' : '' }}">
            <div class="list-group-popular-series">
                <div class="row">
                    <div class="col-xs-12">
                        @foreach ($popularSeries as $item)
                            <div class="list-group-item">
                                <div class="row">
                                @if ($item->type == strtolower(config('popular_series.type.tag')))
                                    <div class="col-xs-4 col-sm-5">
                                        <a href="{{ action('Web\TagsController@show', $item->name_link) }}">
                                            <img src="{{ $item->photo_urls['normal'] }}" class="img-thumbnail">
                                        </a>
                                    </div>
                                    <div class="col-xs-8 col-sm-7">
                                        <a href="{{ action('Web\TagsController@show', $item->name_link) }}">
                                            <p class="pp-item-title">{{ $item->summary }}</p>
                                        </a>
                                    </div>
                                @else
                                    <div class="col-xs-4 col-sm-5">
                                        <a href="{{ action('Web\CategoriesController@show', $item->name_link) }}">
                                            <img src="{{ $item->photo_urls['normal'] }}" class="img-thumbnail">
                                        </a>
                                    </div>
                                    <div class="col-xs-8 col-sm-7">
                                        <a href="{{ action('Web\CategoriesController@show', $item->name_link) }}">
                                            <p class="pp-item-title">{{ $item->summary }}</p>
                                        </a>
                                    </div>
                                @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
        <!-- EOF SERIES -->
    @endif
  </div>
</div>
<!-- EOF POPULAR POST -->