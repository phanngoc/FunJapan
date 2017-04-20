<div class="pull-left profile-picture" style="position:relative;">
    <img class="media-object img-circle" src="assets/images/article/profile_01.png" alt="{{ $comment->user->name }}">
</div>
<div class="media-body">
    <p class="h4 media-heading">{{ $comment->user->name }}</p>
    <div class="pull-right">
        @if ($comment->canBeDeleted())
            <a class="btn-delete" href="javascript:void(0);" data-id="{{ $comment->id }}" style="display: inline;">
                {{ trans('web/comment.button.delete') }}
            </a>
        @endif
    </div>
    @if ($comment->type == config('comment.type.text'))
        <p class="comment-body text-comment break-word">{{ $comment->content }}</p>
    @elseif ($comment->type == config('comment.type.gif'))
        <p class="comment-body"><img class="gif-image" src="{{ $comment->content }}"></p>
    @endif
    <span class="hidden"></span>
    <p class="time">
        <span class="post-text">{{ trans('web/comment.label.posted_at') }}</span>
        <span class="post-date">{{ $comment->posted_time }}</span>
        @if (!$comment->parent_id)
            <a class="comment-reply-panel pull-right" href="javascript:void(0);">
                <i class="fa fa-reply-all"></i>
                <span class="reply-count">{{ $comment->children->count() }}</span>
            </a>
        @endif
    </p>
</div>
<div class="comment-favorite">
    <a class="engagement-favorite engagement-interactive" data-comment-id="{{ $comment->id }}" href="javascript:;">
        <i class="fa fa-heart {{ $comment->isFavorite() ? 'active' : 'disabled' }}"></i>
    </a>
    <span class="engagement-count">{{ $comment->favorite_count }}</span>
</div>
