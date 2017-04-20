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
                <ul class="media-list media-list-comments media-list-comments-replies">
                </ul>
                @if (auth()->check())
                    @include('web.comments._form_reply', [
                        'parentId' => $comment->id,
                        'articleId' => $comment->article_id,
                    ])
                @endif
            </div>
        @endif
    </li>
@endforeach
