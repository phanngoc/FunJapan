$(function () {
    $('div.list-infinity:first').infinitescroll({
        nextSelector: '.next-page a',
        navSelector: '.next-page',
        itemSelector: 'div.list-group-article',
        finished: function () {
            $('#infscr-loading').remove();
        },
        path: function () {
            var nextHref = $('.next-page:last').children('a');
            if (nextHref.length > 0) {
                return nextHref.attr('href');
            }
        }
    }, function (elements, data, url) {
        if ($('.next-page:last').children('a').length == 0) {
            $('div.list-infinity:first').infinitescroll('destroy');
        }
    });
});
