{!! Html::script('assets/js/jquery-2.1.0.min.js') !!}
{!! Html::script('assets/js/jquery-ui-1.11.4.js') !!}
{!! Html::script('assets/js/bootstrap-3.1.1.js') !!}
{!! Html::script('assets/js/bootstrap-fileinput/fileinput.js') !!}
{!! Html::script('assets/js/bootstrap-lightbox/bootstrap-lightbox.js') !!}
{!! Html::script('assets/js/jquery.cookie-1.4.1.js') !!}
{!! Html::script('assets/js/mpf.core.js') !!}
{!! Html::script('assets/js/mpf.linkbuttonbase.min.js') !!}
{!! Html::script('assets/js/mpf.textanimation.min.js') !!}
{!! Html::script('assets/js/mpf.analytics.js') !!}
{!! Html::script('assets/js/mpf.googleanalytics.event.js') !!}
{!! Html::script('assets/js/mpf.userpreference.js') !!}
{!! Html::script('assets/js/Page/Account/BasicProfile.js') !!}
{!! Html::script('assets/js/jquery.mpf.favoritebutton.js') !!}
{!! Html::script('assets/js/mpf.sharebutton.js') !!}
{!! Html::script('assets/js/mpf.commentcount.js') !!}
{!! Html::script('assets/js/mpf.articlephoto.js') !!}
<!-- Slider -->
{!! Html::script('assets/js/mpf.slider.js') !!}
<!-- Slick carousel -->
{!! Html::script('assets/js/mpf.slick-carousel.js') !!}
<!-- Infinite scroll -->
{!! Html::script('assets/js/infinite-scroll/jquery.infinitescroll.js') !!}
<!-- Components-->
<!--Header-->
{!! Html::script('assets/js/mpf.navbar.js') !!}
{!! Html::script('assets/js/mpf.slidecategory.js') !!}
<!-- Load more popular categories -->
{!! Html::script('assets/js/mpf.popular-categories.js') !!}
<script>
$(document).on('ready', function() {
    setTimeout(function() {
        // Carousel
        $('.regular').slick({
            infinite: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 5,
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    arrows: false
                }
            }],
        });
    });
});
</script>
@yield('script')
