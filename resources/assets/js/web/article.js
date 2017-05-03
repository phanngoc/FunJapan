var pagesLoaded = pagesLoaded || [window.location.href];

$(document).ready(function (e) {
    function changeDocumentState()
    {
        var pages = $('div[id^="article-body-"]');
        var index = 0;

        if (pages.length > 0) {
            pages.each(function (itemIndex, item) {
                var articleId = $(item).attr('id');
                if (visibleY(articleId) === true) {
                    index = itemIndex;
                }
            })

            var item = pages.eq(index);

            var itemTitle = item.data('article-title');
            var itemUrl = item.data('article-url');
            var currentTitle = window.location.href;

            var titleIndex = pagesLoaded.indexOf(itemUrl);
            var currentTitleIndex = pagesLoaded.indexOf(currentTitle);

            if (titleIndex != currentTitleIndex) {
                var domainSite = document.title.substring(0, document.title.indexOf('-'));
                document.title = domainSite === "" ? itemTitle : domainSite + "- " + itemTitle;
                window.history.pushState(null, null, itemUrl);
            }
        }
    }

    $(window).scroll(changeDocumentState).resize(changeDocumentState);

    $('div.container:first').infinitescroll({
        nextSelector: ".next-page a",
        navSelector: ".next-page",
        itemSelector: "div.top-body",
        finished: function () {
            $("#infscr-loading").remove();
        },
        path: function () {
            var nextHref = $(".next-page:last").children('a');
            if (nextHref.length > 0) {
                return nextHref.attr("href");
            }
        }
    }, function (elements, data, url) {
        if ($(".next-page:last").children('a').length == 0) {
            $('div.container:first').infinitescroll('destroy');
        }
        pagesLoaded.push(url);
        initDropzone();
    });

});

function visibleY(n)
{
    var t = document.getElementById(n),
        i = t.getBoundingClientRect().top,
        r, t = t.parentNode;
    do {
        if (r = t.getBoundingClientRect(), i <= r.bottom == !1) {
            return !1;
        }
        t = t.parentNode
    } while (t != document.body);
    return i <= document.documentElement.clientHeight
}

function changeLike(articleId)
{
    $.ajax({
        url: baseUrlLocale() + 'articles/' + articleId + '/like',
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