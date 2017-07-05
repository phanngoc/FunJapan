<!-- POPULAR POST -->
@if (count($editorChoices))
    <div class="list-group">
        <div class="list-group__header">
            <span>{{ trans('web/top_page.editor_choice') }}</span>
        </div>
        <div class="list-group__body">
            @foreach ($editorChoices as $post)
            @php
            if (!Auth::check() && $post->is_member_only) {
                $url = route('login');
            } else {
                $url = route('article_detail', $post->article_id);
            }
            @endphp
            <div class="row">
                <div class="col-xs-12">
                    <div class="list-group-item popular-post-item">
                        <div class="row gutter-12">
                            <div class="col-md-39 popular-post-item__thumbnail">
                                <a href="{{ $url }}">
                                    <img src="{{ $post->thumbnail_urls['small'] }}">
                                </a>
                            </div>
                            <div class="col-md-61">
                                <div class="popular-post-item__info">
                                    <a href="{{ $url }}">
                                        <p class="popular-post-item__info">{{ $post->getShortTitle() }}</p>
                                    </a>
                                    <ul class="engagement">
                                        <li>
                                            <a class="engagement-favorite" href="#">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                            <span class="engagement-count">{{ $post->like_count }}</span>
                                        </li>
                                        <li>
                                            <a class="engagement-comment" href="#">
                                                <i class="fa fa-comment"></i>
                                            </a>
                                            <span class="engagement-count">{{ $post->comment_count }}</span>
                                        </li>
                                        <li>
                                            <a class="engagement-share" href="#">
                                                <i class="fa fa-share-alt"></i>
                                            </a>
                                            <span class="engagement-count">{{ $post->share_count }}</span>
                                        </li>
                                    </ul>
                                    <img class="popular-post-item__icon" src="{{ $post->category->icon_urls['normal'] ? : '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endif
<!-- EOF POPULAR POST -->
