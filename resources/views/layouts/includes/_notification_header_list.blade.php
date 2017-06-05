@if (isset($notifications) && $notifications->count())
    <div class="dropdown-menu notifications">
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
@else
    <div class="dropdown-menu notifications">
        <div class="notification-list">
            <ul>
                <li class="no-notifications">
                    <a href="javascript:;">
                        <div class="notification">
                            <div class="message">
                                <p class="text-center">
                                    <span class="action"><b>No Notifications</b></span>
                                </p>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="show-all">
            <a href="#">{{ trans('web/notification.label.show_all') }}</a>
        </div>
    </div>
@endif
