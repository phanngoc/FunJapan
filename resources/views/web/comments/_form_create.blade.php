{{ Form::open([
    'action' => 'Web\CommentsController@store',
    'method' => 'POST',
    'class' => 'form-gif-comment',
]) }}
    {{ Form::hidden('content', null, ['class' => 'comment-gif-input']) }}
    {{ Form::hidden('articleId', $articleLocale->article_id) }}
    {{ Form::hidden('articleLocaleId', $articleLocale->id) }}
    {{ Form::hidden('type', config('comment.type.gif')) }}
{{ Form::close() }}

{{ Form::open([
    'action' => 'Web\CommentsController@store',
    'method' => 'POST',
    'class' => 'comment-to-top form-create-comment form-comment',
]) }}
    {{ Form::textarea('content', null, [
        'class' => 'comment-input form-control no-radius-bot',
        'placeholder' => trans('web/comment.place_holder.create_comment'),
        'rows' => 4,
    ]) }}
    {{ Form::hidden('articleId', $articleLocale->article_id) }}
    {{ Form::hidden('articleLocaleId', $articleLocale->id) }}
    {{ Form::hidden('type', config('comment.type.text')) }}
    <div class="row radius-bot">
        <div class="col-xs-8 text-left">
            <span type="button" class="btn btn-gif show-gifs-selection">GIF</span>
            @include('web.comments._popup_gif')
            <i class="fa fa-smile-o btn btn-twemoji" aria-hidden="true"></i>
            <div class="popup-emoticon"></div>
        </div>
        <div class="col-xs-4 text-right">
            <button type="button" class="btn btn-default send-comment" id="post-btn">
                <i class="fa fa-comments-o" aria-hidden="true"></i>
            </button>
        </div>
    </div>
{{ Form::close() }}
