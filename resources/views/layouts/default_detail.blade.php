<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        @include('layouts.includes.head')
        <title>{{ $title ?? trans('web/global.title', ['article_title' => '']) }}</title>
        @include('layouts.includes.scripts_detail')
        @include('layouts.includes.styles')
    </head>
    <body>
        <div class="top-container" id="top-container">
            <div class="container detail">
                @include('layouts.includes.header_detail')
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
                                    <button type="button" class="btn btn-primary confirm-delete" data-comment-id="" data-article-id="">
                                        {{ trans('web/comment.button.yes') }}
                                    </button>
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
                                    <img src="" class="hidden">
                                    <p>{{ trans('web/comment.messages.confirm_post_gif') }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('web/comment.button.no') }}</button>
                                    <button type="button" class="btn btn-primary confirm-post-gif" data-comment-gif="" data-article-id="">
                                        {{ trans('web/comment.button.yes') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- EOF CONFIRM GIF MODAL -->
                <div class="top-body" id='article-body-{{ $article->id}}'>
                    @if ($errors->any() || session()->has('message') || session()->has('error'))
                        @include('web.articles._notice_messages')
                    @else
                        <div class="main-content">
                            <div class="row gutter-32">
                                @yield('content')
                                @include('web.includes._side_bar_detail')
                            </div>
                            @if ($article->post_photo)
                                @include('web.articles._post_photo', [
                                    'articleLocale' => $article->locale ?? null,
                                    'postPhotos' => $postPhotos ?? null,
                                ])
                            @endif
                            @include('web.articles._related_articles', ['articles' => $article->relateArticle])
                        </div>
                        <div class="next-page">
                            @if ($nextArticle && isset($nextArticle->article_id))
                                <a href="{{ url('articles/' . $nextArticle->article_id) }}"></a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
