{!! Html::script('assets/js/jquery-2.1.0.min.js') !!}
{!! Html::script('assets/js/jquery-ui-1.11.4.js') !!}
{!! Html::script('assets/js/bootstrap-3.1.1.js') !!}
{!! Html::script('assets/js/bootstrap-fileinput/fileinput.js') !!}
{!! Html::script('assets/js/bootstrap-lightbox/bootstrap-lightbox.js') !!}
{!! Html::script('assets/js/jquery.cookie-1.4.1.js') !!}
{!! Html::script('assets/js/Page/Account/BasicProfile.js') !!}
{!! Html::script('assets/js/moment.js') !!}
{!! Html::script('assets/js/jquery.custom-scrollbar.js') !!}
{!! Html::script('assets/js/jquery.validate.min.js') !!}
{!! Html::script('assets/js/additional-methods.min.js') !!}

<script>
    $(function() {
        $('.scrollbar-inner').customScrollbar({
            skin: "default-skin",
            hScroll: false,
            updateOnWindowResize: true
        });
    });
</script>
@yield('script')
