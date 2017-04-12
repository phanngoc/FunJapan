function runShareFunction(){

    popoverElement = $('.engagement-share.engagement-interactive');

    if (Modernizr.csstransitions) {
        $('.engagement-share').next("span.engagement-count").addClass("fa fa-spinner fa-spin");
    };

    $(".engagement-share").each(function () {
        loadCount($(this));
    });

    var articleUrl = popoverElement.attr("data-mpf-article-url");        

    var content = '<a class="popover-item-share" target="_blank" href="' + "https://www.facebook.com/sharer/sharer.php?u=" + articleUrl + '" data-socialmedia="facebook">' +
                   '<i class="fa fa-facebook-square fa-2x"></i>' +
                 '</a> ' +
                 '<a class="popover-item-share" target="_blank" href="' + "https://twitter.com/intent/tweet?text=" + encodeURIComponent($('h1').text()) + "%0a&url=" + articleUrl + '" data-socialmedia="twitter">' +
                   '<i class="fa fa-twitter-square fa-2x"> </i>' +
                 '</a>' +
                 '<a class="popover-item-share" target="_blank" href="' + "https://plus.google.com/share?url=" + articleUrl + '" data-socialmedia="googleplus">' +
                  '<i class="fa fa-google-plus-square fa-2x"></i>' +
                 '</a>';
                 
    if (MPF.current.device.isMobile) {
        content = content + '<a class="popover-item-share" target="_blank" href=whatsapp://send?text=' + encodeURIComponent($('h1').text()) + "%0a" + articleUrl + ' data-socialmedia="whatsup">' +
                  '<i class="fa fa-2x"></i>' +
                 '</a>' +
                 '<a class="popover-item-share" target="_blank" href="' + "http://line.me/R/msg/text/?" + encodeURIComponent($('h1').text()) + "%0a" + articleUrl + '" data-socialmedia="line">' +
                  '<i class="fa fa-2x"></i>' +
                 '</a>';
    };

    if (!MPF.current.user.isAuthenticated) {
        content = content + '<p style="margin-bottom: 0px;">' +
            '<strong><small>' +
            '<a href="' + MPF.getLoginUrl() + '">Login</a>' +
            ' or <a href="' + MPF.getRegisterUrl() + '">Register</a>' +
            '</small></strong>' +
            '</p>'
    };

    popoverElement.popover({
        html: true,
        placement: "bottom",
        content: content,

    }).parent().on('click', '.popover-item-share', function () {
        var selectedMedia = $(this).attr('data-socialmedia');
        popoverElement.popover('hide');

        $.ajax({
            url: MPF.config.api.baseUrl + 'articles/' + popoverElement.attr("data-mpf-article-id") + '/shares' + '/' + selectedMedia + (MPF.current.user.isAuthenticated ? '' : '/anonymous'),
            type: 'post',
            headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken },
            data: selectedMedia
        }).always(function () {
            loadCount(popoverElement);
        });
    });
};

function loadCount(e) {
    $.ajax({
        url: MPF.config.api.baseUrl + 'articles/' + e.attr("data-mpf-article-id") + '/shares/count',
        type: 'GET'
    }).done($.proxy(function (count) {
        e.nextAll('span.engagement-count').removeClass("fa fa-spinner fa-spin").text(count);
    }, this));
};
