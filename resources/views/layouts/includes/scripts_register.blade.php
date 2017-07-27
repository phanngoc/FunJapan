@include('layouts.includes.scripts')

{{ Html::script('assets/js/vendor/jquery.custom-scrollbar.js') }}
{{ Html::script('assets/js/vendor/jquery.validate.min.js') }}
{{ Html::script('assets/js/vendor/additional-methods.min.js') }}
{{ Html::script('assets/js/web/jmb.js') }}
@yield('script')
