function countCommentFunction(webApiSiteUrl) {
    var commentElement = $('.engagement-comment');
    
    if (Modernizr.csstransitions) {
        commentElement.next("span.engagement-count").addClass("fa fa-spinner fa-spin");
    }

    var loadCount = function (e) {
        $.ajax({
            url: webApiSiteUrl + 'articles/' + e.attr("data-mpf-article-id") + '/comments/count',
            type: 'GET'
        }).done($.proxy(function (count) {
            e.nextAll('span.engagement-count').removeClass("fa fa-spinner fa-spin").text(count);
        }, this));
    }

    commentElement.each(function () {
        loadCount($(this));
    })
}
