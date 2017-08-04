@foreach ($notifications as $notification)
    @include('layouts.includes._single_notification', ['notification' => $notification])
@endforeach