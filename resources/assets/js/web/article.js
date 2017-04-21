baseUrl = function () {
    return window.location.protocol + '//' + window.location.host;
};

$(document).ready(function (e) {
    $('.fa-heart').on('click', function () {
        var articleId = $(this).attr('data-article-id');
        $.ajax({
            url: baseUrl() + '/articles/' + articleId + '/like',
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
    });
});