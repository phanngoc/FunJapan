{{ Html::script('assets/js/vendor/jquery-3.2.1.js') }}
{{ Html::script('assets/js/vendor/bootstrap-3.1.1.js') }}
{{ Html::script('assets/js/web/app.js') }}
{{ Html::script('assets/momentjs/moment.min.js') }}
{{ Html::script('assets/momentjs/moment-with-locales.js') }}
{{ Html::script('assets/momentjs/moment-timezone.min.js') }}
{{ Html::script('assets/momentjs/moment-timezone-with-data.js') }}
{{ Html::script('assets/momentjs/moment-timezone-with-data-2012-2022.js') }}
<script>
    var BASE_URL = '{{ url('') }}';
    var BASE_LOCALE = '{{ App::getLocale() }}';
</script>
@if (auth()->check() && config('notification.echo_server_enable'))
    <script type="text/javascript">
        var channel = "{{ $currentLocale . '.' . auth()->id() }}";
        var urlGetNotifications = "{{ action('Web\NotificationsController@list') }}";
        var urlDismissNotifications = "{{ action('Web\NotificationsController@dismiss') }}";
        var urlEchoServer = "{{ config('notification.echo_server_url') }}";
        var timezone = "{{ config('app.timezone') }}";
        moment.locale("{{ $currentLocale ?? 'en' }}");
    </script>

    {{ Html::script(config('notification.echo_server_url') . '/socket.io/socket.io.js') }}
    {{ Html::script('assets/js/app.js') }}
    {{ Html::script('assets/js/web/notification.js') }}
@endif
