{{ Html::script('assets/js/vendor/jquery-3.2.1.js') }}
{{ Html::script('assets/js/vendor/bootstrap-3.1.1.js') }}
{{ Html::script('assets/js/vendor/slick-carousel.js') }}
<!-- Category-->
{{ Html::script('assets/js/main/popular-categories.js') }}
<!-- Navbar-->
{{ Html::script('assets/js/main/navbar.js') }}
{{ Html::script('assets/js/main/slidecategory.js') }}
<!-- Slider-->
{{ Html::script('assets/js/main/slider.js') }}
<!-- Carousel-->
{{ Html::script('assets/js/main/slick-carousel-custom.js') }}
<script>
$(function() {
    // Navbar
    $('.fj-navbar').affix({
        offset: {
            top: 504
        }
    });
    $('.fj-navbar-mobile').affix({
        offset: {
            top: 215
        }
    });
});
</script>
@yield('script')