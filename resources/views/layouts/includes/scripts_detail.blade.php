{!! Html::script('assets/js/jquery-2.1.0.min.js') !!}
{!! Html::script('assets/js/jquery-ui-1.11.4.js') !!}
{!! Html::script('assets/js/bootstrap-3.1.1.js') !!}
{!! Html::script('assets/js/bootstrap-fileinput/fileinput.js') !!}
{!! Html::script('assets/js/bootstrap-lightbox/bootstrap-lightbox.js') !!}
{!! Html::script('assets/js/jquery.cookie-1.4.1.js') !!}
{!! Html::script('assets/js/Page/Account/BasicProfile.js') !!}
{!! Html::script('https://twemoji.maxcdn.com/twemoji.min.js?2.2.2') !!}
<!-- Slider -->
{!! Html::script('assets/js/mpf.slider.js') !!}
<!-- Infinite scroll -->
{!! Html::script('assets/js/infinite-scroll/jquery.infinitescroll.js') !!}
<!-- Component -->
<!--Header-->
{!! Html::script('assets/js/mpf.navbar.js') !!}
<script>
    $(document).ready(function() {
        $('#show-comment-btn').click(function() {
            let commentModal = $('#comment-modal').find('.modal-content');
            if (commentModal.children().length == 0) {
                commentModal.append($('#comment-area-desktop').children().clone(true, true));
                commentModal.find('.list-group-header').css('display', 'none');
                commentModal.find('.hide-comment-modal').css('display', 'block');
            }
            $(this).parents().find('.show-comment-modal').css('display', 'none');

            $('#comment-modal').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        $('#hide-comment-btn').click(function() {
            $('.show-comment-modal').css('display', 'block');
            $('#comment-modal').modal('hide');
        });

        setTimeout(function() {
            // Navbar
            $('.fj-navbar').affix({
                offset: {
                    top: 104
                }
            });
            $('.fj-navbar-mobile').affix({
                offset: {
                    top: 40
                }
            });
        }, 5);
    });
</script>
@yield('script')
