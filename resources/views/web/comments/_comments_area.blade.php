<!-- COMMENT AREA -->
<div class="comment-area" data-article-id="{{ $articleLocale->article_id }}" data-article-locale-id="{{ $articleLocale->id }}">
    <div id="comment-area-desktop">
        <div class="list-group">
            <div class="list-group-header">
                <p class="list-group-title">
                    <span class="comment-count">{{ $articleLocale->comment_count }}</span> {{ trans('web/comment.label.comments_uppercase') }}
                </p>
            </div>
            <!-- HIDE COMMENT MODAL BTN -->
            <div class="hide-comment-modal">
                <p><span class="comment-count">{{ $articleLocale->comment_count }}</span> {{ trans('web/comment.label.comments_uppercase') }}
                    <a id="hide-comment-btn">
                        <span class="suggest-text pull-right">
                            {{ trans('web/comment.label.close') }}
                            <i class="fa fa-times pull-right" aria-hidden="true"></i>
                        </span>
                    </a>
                </p>
            </div>
            <!-- EOF HIDE COMMENT MODAL BTN -->
        </div>
        <div class="comment-posting-form">
            <div class="alert alert-danger hidden">
            </div>
            @if (auth()->check())
                @include('web.comments._form_create', ['articleLocale' => $articleLocale])
            @else
                <div class="login-requirement">
                    <span>
                        <a href="{{ route('login') }}">{{ trans('web/comment.label.login') }}</a>
                        {{ trans('web/comment.label.or') }}
                        <a href="{{ route('register') }}">{{ trans('web/comment.label.create_account') }}</a>
                        {{ trans('web/comment.label.to_join') }}
                    </span>
                </div>
            @endif
            <div class="comments-loading hidden">
                <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
            </div>
            <ul class="media-list media-list-comments comments-list">
                @include('web.comments._list_comments', ['comments' => $comments])
            </ul>
            <div class="comment-pagination text-center">
                @include('web.comments._pagination', ['paginator' => $comments])
            </div>
        </div>
    </div>
    <!-- COMMENT MODAL -->
    <div class="modal fade" id="comment-modal">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!-- EOF COMMENT MODAL -->
    <!-- SHOW COMMENT MODAL BTN -->
    <div class="show-comment-modal">
        <p><span class="comment-count">{{ $articleLocale->comment_count }}</span> {{ trans('web/comment.label.comments_uppercase') }}
            <a id="show-comment-btn">
                <span class="suggest-text pull-right">
                    {{ trans('web/comment.label.swipe_up') }}
                    <i class="fa fa-hand-o-up" aria-hidden="true"></i>
                </span>
            </a>
        </p>
    </div>
    <!-- EOF SHOW COMMENT MODAL BTN -->
</div>
<!-- EOF COMMENT AREA -->
{{ Html::script('assets/js/web/comments.js') }}
