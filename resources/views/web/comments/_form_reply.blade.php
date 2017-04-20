<div class="comment-reply-form comment-posting-form" style="display: block">
    <div class="alert alert-danger hidden">
    </div>
    {{ Form::open([
        'action' => 'Web\CommentsController@store',
        'method' => 'POST',
        'class' => 'comment-to-top form-comment',
    ]) }}
        {{ Form::textarea('content', null, [
            'class' => 'reply-comment-input comment-input',
            'placeholder' => trans('web/comment.place_holder.reply_comment'),
        ]) }}
        <i class="fa fa-smile-o btn btn-twemoji" aria-hidden="true"></i>
        <div class="popup-emoticon"></div>
    {{ Form::hidden('type', config('comment.type.text')) }}
    {{ Form::hidden('parentId', $parentId ?? null) }}
    {{ Form::hidden('articleId', $articleId) }}
    {{ Form::close() }}
</div>
