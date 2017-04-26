@include('layouts.includes.scripts')

<!-- Navbar-->
{{ Html::script('assets/js/main/navbar.js') }}
{{ Html::script('assets/js/main/slidecategory.js') }}
<!-- Comment-->
{{ Html::script('assets/js/main/comment.js') }}
{{ Html::script('https://twemoji.maxcdn.com/twemoji.min.js?2.2.2') }}
{{ Html::script('assets/js/web/infinite-scroll/jquery.infinitescroll.js') }}
{{ Html::script('assets/admin/js/plugins/dropzone/dropzone.js') }}
{{ Html::script('assets/js/web/article.js') }}
{{ Html::script('assets/js/web/post_photo.js') }}

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
