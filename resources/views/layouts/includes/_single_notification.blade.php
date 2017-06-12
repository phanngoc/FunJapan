<li>
    <a href="{{ action('Web\ArticlesController@show', $notification->targetItem->articleLocale->article_id) }}">
        <div class="notification">
            @if (isset($notification->sender->avatar))
                <img src="{{ $notification->sender->avatar_url }}">
            @else
                <i class="fa fa-user-circle fa-2x"></i>
            @endif
            <div class="message">
                <p class="single-line">
                    <span class="elap">...</span>
                    <span class="name">{{ $notification->sender->name ?? 'Unknow' }}</span>
                    <span class="action">{{ trans('web/notification.messages.' . $notification->type) }}</span>
                </p>
                <p class="time" data-time="{{ $notification->created_at }}">
                    <i class="fa fa-clock-o"></i>
                    <span>{{ $notification->created_at }}</span>
                </p>
            </div>
        </div>
    </a>
</li>
