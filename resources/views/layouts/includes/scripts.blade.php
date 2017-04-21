{{ Html::script('assets/js/vendor/jquery-3.2.1.js') }}
{{ Html::script('assets/js/vendor/bootstrap-3.1.1.js') }}
{{ Html::script('assets/js/web/app.js') }}

<script>
    var BASE_URL = '{{ url('') }}';
    var BASE_LOCALE = '{{ App::getLocale() }}';
</script>