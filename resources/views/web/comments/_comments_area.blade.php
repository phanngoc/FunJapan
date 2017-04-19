<!-- COMMENT AREA -->
<div id="comment-area" class="comment-area" data-article-id="{{ $articleLocale->article_id }}" data-article-locale-id="{{ $articleLocale->id }}">
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
            <ul class="media-list media-list-comments comments-list">
            </ul>
            <div class="comment-pagination text-center">
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
    <!-- DELETE COMMENT MODAL -->
    <div class="modal fade" id="delete-comment-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('web/comment.messages.confirm_delete') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('web/comment.button.no') }}</button>
                    <button type="button" class="btn btn-primary confirm-delete" data-comment-id="">{{ trans('web/comment.button.yes') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- EOF DELETE COMMENT MODAL -->
    <!-- CONFIRM GIF MODAL -->
    <div class="modal fade" id="confirm-gif-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('web/comment.messages.confirm_post_gif') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('web/comment.button.no') }}</button>
                    <button type="button" class="btn btn-primary confirm-post-gif" data-comment-gif="">{{ trans('web/comment.button.yes') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- EOF CONFIRM GIF MODAL -->
</div>
<!-- EOF COMMENT AREA -->
{{ Html::script('assets/js/web/comments.js') }}
