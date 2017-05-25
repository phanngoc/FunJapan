<div class="articlephoto col-xs-3 text-center">
    <div class="articlephoto-image" style="height: 227px;">
        <a class="image-popup-vertical-fit fancybox" href="{{ $postPhoto->photo_urls['original'] }}" target="_blank" title="{{ $postPhoto->content }}">
            <img class="img-thumbnail" src="{{ $postPhoto->photo_urls['thumbnail'] }}">
        </a>
    </div>
    <div>
        <div class="text-left articlephoto-meta">
            <span class="datetime">{{ $postPhoto->posted_time }}</span>
            <a href="{{ auth()->check() ? 'javascript:void(0)' : route('login') }}"
                class="engagement-favorite articlephoto-like {{ $postPhoto->isFavorite() ? 'liked' : '' }}"
                data-url="{{ action('Web\ArticlePhotosController@favorite', $postPhoto->id) }}">
                <i class="fa fa-heart"></i>
                <span>&nbsp;&nbsp;&nbsp;
                    <b class="favorite-count">{{ $postPhoto->favorite_count }}</b>
                </span>
            </a>
        </div>
        <strong>
            <p class="articlephoto-postedby">{{ $postPhoto->user->name }}</p>
        </strong>
        <div class="articlephoto-message">
            <p class="text-left break-word">{{ $postPhoto->content ? str_limit($postPhoto->content, config('limitation.post_photo.description')) : '' }}</p>
        </div>
    </div>
</div>
