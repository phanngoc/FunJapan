@foreach ($comments as $comment)
    <li class="media no-overflow-hidden parent-comment">
        @include('web.comments._single_comment', ['comment' => $comment])
        @if ($comment->children->count())
                <!-- REPLY COMMENT -->
                <div class="comment-reply-container" style="display:none">
                    <ul class="media-list media-list-comments media-list-comments-replies">
                        @foreach ($comment->children as $children)
                            <li class="media no-overflow-hidden">
                                @include('web.comments._single_comment', ['comment' => $children])
                            </li>
                        @endforeach
                        @if (!auth()->check())
                            <li class="media no-overflow-hidden alert-login">
                                <a href="{{ route('login') }}">{{ trans('web/comment.label.login') }}</a>
                                {{ trans('web/comment.label.or') }}
                                <a href="{{ route('register') }}">{{ trans('web/comment.label.create_account') }}</a>
                                {{ trans('web/comment.label.to_join') }}
                            </li>
                        @endif
                    </ul>
                    @if (auth()->check())
                        @include('web.comments._form_reply', [
                            'parentId' => $comment->id,
                            'articleId' => $comment->article_id,
                        ])
                    @endif
                </div>
                <!-- EOF REPLY COMMENT -->
        @else
            <div class="comment-reply-container" style="display:none">
                @if (auth()->check())
                    <ul class="media-list media-list-comments media-list-comments-replies">
                    </ul>
                    @include('web.comments._form_reply', [
                        'parentId' => $comment->id,
                        'articleId' => $comment->article_id,
                    ])
                @else
                    <ul class="media-list media-list-comments media-list-comments-replies">
                        <li class="media no-overflow-hidden alert-login">
                            <a href="{{ route('login') }}">{{ trans('web/comment.label.login') }}</a>
                            {{ trans('web/comment.label.or') }}
                            <a href="{{ route('register') }}">{{ trans('web/comment.label.create_account') }}</a>
                            {{ trans('web/comment.label.to_join') }}
                        </li>
                    </ul>
                @endif
            </div>
        @endif
    </li>
@endforeach
