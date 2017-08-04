<li>
    <a href="{{ isset($notification->targetItem) ? action('Web\ArticlesController@show', $notification->targetItem->articleLocale->article_id) : '#' }}">
        <div class="notification">
            @if (isset($notification->sender->avatar))
                <img src="{{ $notification->sender->avatar_url }}">
            @else
                <i class="fa fa-user-circle fa-2x"></i>
            @endif
            <div class="notification__message {{ $notification->status == config('notification.status.un_read') ? 'notification__message--new' : null  }}">
                <p class="notification__content">
                    <span class="notification__user-name">
                        {{ $notification->sender->name ?? 'Unknow' }}
                    </span>
                    <span class="notification__action">
                        {{ trans('web/notification.messages.' . $notification->type) }}
                    </span>
                </p>
                <p class="notification__time" data-time="{{ $notification->created_at }}">
                    <i class="fa fa-clock-o"></i>
                    <span>{{ $notification->created_at }}</span>
                </p>
            </div>
        </div>
    </a>
</li>
