{{ Html::script('assets/js/vendor/jquery-3.2.1.js') }}
{{ Html::script('assets/js/vendor/bootstrap-3.1.1.js') }}
<!-- Navbar-->
{{ Html::script('assets/js/main/navbar.js') }}
{{ Html::script('assets/js/main/slidecategory.js') }}
<!-- Comment-->
{{ Html::script('assets/js/main/comment.js') }}
{{ Html::script('https://twemoji.maxcdn.com/twemoji.min.js?2.2.2') }}
{{ Html::script('assets/js/web/article.js') }}
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
