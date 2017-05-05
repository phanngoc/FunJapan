<div class="pull-left profile-picture" style="position:relative;">
    @if ($comment->user->avatar)
        <img class="media-object img-circle" src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}">
    @else
        <i class="fa fa-user-circle fa-3x"></i>
    @endif
</div>
<div class="media-body">
    <p class="h4 media-heading width-85-pc break-word">{{ $comment->user->name }}</p>
    <div class="pull-right">
        @if ($comment->canBeDeleted())
            <a class="btn-delete" href="javascript:void(0);" data-article-id="{{ $comment->article_id }}"
                data-id="{{ $comment->id }}" style="display: inline;">
                {{ trans('web/comment.button.delete') }}
            </a>
        @endif
    </div>
    @if ($comment->type == config('comment.type.text'))
        @if (strlen($comment->content) > config('limitation.comment.content'))
            <div class="body-comment">
                <p class="limited-text comment-body text-comment break-word">{{ str_limit($comment->content, config('limitation.comment.content')) }}</p>
                <a href="javascript:;" class="show-comment">{{ trans('web/comment.button.more') }}</a>
                <p class="full-text comment-body text-comment break-word hidden">{{ $comment->content }}</p>
            </div>
        @else
            <p class="comment-body text-comment break-word">{{ $comment->content }}</p>
        @endif
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
    <span class="engagement-count">{{ $comment->favorite_count ?? 0 }}</span>
</div>
