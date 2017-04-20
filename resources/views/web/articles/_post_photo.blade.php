<p class="h2 blacksquare content-title">{{ trans('web/post_photo.label.photo_post') }}</p>
<div class="text-center" style="margin-bottom: 30px;">
    <div class="alert post-photo-alert hidden"></div>
    <form action="/articles/{{ $articleLocale->article_id }}/photo" method="POST" id="upload-photo-{{$articleLocale->article_id}}"
        data-article-id="{{ $articleLocale->article_id }}" class="upload-photo dropzone"></form>
    <form action="/" enctype="multipart/form-data" method="post">
        <div class="articlephoto-upload form-group">
            <div style="margin-bottom:10px;">
                <span class="file-input file-input-new">
                    <div class="input-group ">
                        <div tabindex="-1" class="form-control file-caption kv-fileinput-caption">
                            <span class="file-caption-ellipsis" title=""></span>
                            <div class="file-caption-name" title=""></div>
                        </div>
                        <div class="input-group-btn">
                            <div class="btn btn-primary btn-file">
                                <i class="fa fa-folder-open-o"></i>
                                {{ trans('web/post_photo.label.browse') }}<a class="file" class="input-file-image"></a>
                            </div>
                        </div>
                    </div>
                </span>
            </div>
            <input type="text" name="photoMessage" class="form-control photo-description"
                placeholder="{{ trans('web/post_photo.place_holder.write_description') }}" maxlength="100">
        </div>
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 btn-upload-photo hidden" alert-description="{{ trans('web/post_photo.messages.no_description') }}">
                <button class="articlephoto-upload-btn btn btn-primary form-control">{{ trans('web/post_photo.button.post') }}</button>
            </div>
        </div>
    </form>
</div>
<p class="h2 blacksquare content-title">{{ trans('web/post_photo.label.posted_photo') }}</p>
<div>
    <div class="articlephoto-condition row">
        <div class="col-xs-12 col-sm-6">
            <div class="articlephoto-search input-group">
                <input type="text" name="search-photo-keywords"
                    placeholder="{{ trans('web/post_photo.place_holder.search_by_user') }}" class="form-control search-photo-keywords">
                <span class="input-group-btn">
                    <button type="button" class="btn search-photo-by-user">
                        <span class="fa fa-search"></span>
                    </button>
                </span>
            </div>
        </div>
        <div class="articlephoto-order text-right col-xs-12 col-sm-6">
            <a data-orderby="created_desc" class="current-order get-order-photo" href="javascript:void(0);">{{ trans('web/post_photo.label.order.newest') }}</a>
            <a data-orderby="created_asc" class="get-order-photo" href="javascript:void(0);">{{ trans('web/post_photo.label.order.oldest') }}</a>
            <a data-orderby="popular" class="get-order-photo" href="javascript:void(0);">{{ trans('web/post_photo.label.order.popular') }}</a>
        </div>
    </div>
    <hr>
    <div class="row article-list-photo">
        <div class="articlephoto-area col-xs-12">
            @include('web.articles._list_post_photos', ['postPhotos' => $postPhotos ?? null])
        </div>
        @if ($postPhotos->currentPage() < $postPhotos->lastPage() && $postPhotos->lastPage() != 0)
            <div class="text-right col-xs-12">
                <a class="articlephoto-more" href="javascript:void(0)" data-current-page="{{ $postPhotos->currentPage() }}">
                    {{ trans('web/post_photo.button.more') }}
                </a>
            </div>
        @endif

    </div>
</div>
{{ Html::script('assets/js/web/post_photo.js') }}
