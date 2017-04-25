$(document).ready(function (e) {
    $('div.container:first').infinitescroll({
        nextSelector: ".next-page a",
        navSelector: ".next-page",
        itemSelector: "div.top-body",
        bufferPx: 0,
        finished: function () {
            $("#infscr-loading").remove();
        },
        path: function() {
            var nextHref = $(".next-page:last").children('a');
            if (nextHref.length > 0) {
                nextHref = nextHref.attr("href");
                window.history.pushState(null, null, nextHref);
                return nextHref;
            }
        }
    }, function() {
        if ($(".next-page:last").children('a').length == 0) {
            $('div.container:first').infinitescroll('destroy');
        }
    });
});

function changeLike(articleId) {
    $.ajax({
        url: baseUrlLocale() + '/articles/' + articleId + '/like',
        type: 'GET',
        success: function (response) {
            $('.engagement-count').text(response.count);
            if (response.check) {
                $('.engagement-count, .engagement-favorite').addClass('active');
            } else {
                $('.engagement-count, .engagement-favorite').removeClass('active');
            }
        }
    });
}