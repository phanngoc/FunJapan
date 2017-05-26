@if (isset($notifications))
    <div class="dropdown-menu notifications {{ $notifications->count() ? '' : 'hidden' }}">
        <div class="notification-list">
            <ul>
                @foreach ($notifications as $notification)
                    @include('layouts.includes._single_notification', ['notification' => $notification])
                @endforeach
            </ul>
        </div>
        <div class="show-all">
            <a href="#">{{ trans('web/notification.label.show_all') }}</a>
        </div>
    </div>
@endif
