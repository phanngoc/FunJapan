var articleId = $('#comment-area').attr('data-article-id');
var articleLocaleId = $('#comment-area').attr('data-article-locale-id');

$(function () {
    parseEmojiComment();
    getItems('/comments/lists/' + articleId + '/' + articleLocaleId + '?page=1', true);

    $('body').on('click', '.btn-twemoji', function (event) {
        event.stopPropagation();
        var emojiPicker = $('#emoji-picker-block');
        if (emojiPicker.css('display') == 'block') {
            emojiPicker.css('display', 'none');
            $('.popup-emoticon').html('');
        } else {
            $('#gifs-search-block').css('display', 'none');
            getEmojiPopup($(this));
        }
    });

    $('.show-gifs-selection').on('click', function (event) {
        var gifPicker = $('#gifs-search-block');
        $('#search-gif-input').val('');

        if (gifPicker.css('display') == 'block') {
            gifPicker.css('display', 'none');
        } else {
            gifPicker.css('display', 'block');
            $('#emoji-picker-block').css('display', 'none');

            $.ajax({
                'url': 'https://api.tenor.co/v1/trending?key=LIVDSRZULELA',
                'type': 'GET',
                'data': {},
                success: (data) => {
                    $('#gifs-search-block .body-result-gifs').html('');
                    $.each(data.results, function( key, value ) {
                        $('#gifs-search-block .body-result-gifs').append('<img class="gif-image" alt="" src="' + value.media[0]['gif']['url'] + '">');
                    });
                }
            });
        }
    });

    $('#search-gif-input').keypress(function (e) {
        if (e.which == 13) {
            searchGif();
            return false;
        }
    });

    $('#gifs-search-block').on('click', '#search-gif-btn', function () {
        searchGif();
    });

    $('#close-gif-popup-btn').on('click', function () {
        $('#gifs-search-block').css('display', 'none');
    });

    $('#gifs-search-block .body-result-gifs').on('click', '.gif-image', function () {
        $('form.form-gif-comment .comment-gif-input').val($(this).attr('src'));
        var data = $('form.form-gif-comment').serialize();
        $('#confirm-gif-modal').find('.confirm-post-gif').attr('data-comment-gif', data);
        $('#confirm-gif-modal').modal('show');
        $('#gifs-search-block').css('display', 'none');
    });

    $('#confirm-gif-modal').on('click', '.confirm-post-gif', function () {
        $('#confirm-gif-modal').modal('hide');
        var data = $(this).attr('data-comment-gif');
        $('#confirm-gif-modal').find('.confirm-post-gif').attr('data-comment-gif', '');
        var alertArea = $('.comment-posting-form').find('.alert-danger:first');
        alertArea.addClass('hidden').html('');
        $('.comments-list').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');

        $.ajax({
            'url': '/comments',
            'type': 'POST',
            'data': data,
            success: (response) => {
                if (response.success) {
                    $('.comments-list').html('').append(response.htmlComments);
                    $('.comment-count').html(response.total);
                    $('.comment-pagination').html('').append(response.htmlPaginator);
                    parseEmojiComment();
                } else {
                    alertArea.removeClass('hidden').append('<ul><li>' + response.message + '</li></ul>');
                }

                $('#gifs-search-block').css('display', 'none');
            }
        });
    });

    $('body').on('click', '#emoji-picker-block .popup-content li', function () {
        var input = $(this).parents('.form-comment').find('.comment-input');
        input.val(input.val() + $(this).find('img').attr('alt'));
    });

    $('body').on('click', '.category-menu-emoji-list span', function () {
        $('body .category-menu-emoji-list').find('span').each(function () {
            $(this).removeClass('active');
        });

        $(this).addClass('active');
        var dataCategory = $(this).data('category');
        getEmoji(dataCategory);

        $('body #emoji-picker-block').find('.body-twitter-emoji-list').each(function () {
            $(this).addClass('hidden');
        });
        $('body #emoji-picker-block').find('.body-twitter-emoji-list.' + dataCategory).removeClass('hidden');
    });

    $('.send-comment').on('click', function () {
        var data = $('form.form-create-comment').serialize();
        $('.comment-posting-form').find('.alert-danger').addClass('hidden');
        var alertArea = $(this).parents('.comment-posting-form').find('.alert-danger:first');
        alertArea.addClass('hidden').html('');

        if ($('.comment-input').val() != '') {
            $('.comments-list').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');

            $.ajax({
                'url': '/comments',
                'type': 'POST',
                'data': data,
                success: (response) => {
                    if (response.success) {
                        $('.comment-input').val('');
                        $('.comments-list').html('').append(response.htmlComments);
                        $('.comment-count').html(response.total);
                        if (response.htmlPaginator != '') {
                            $('.comment-pagination').html('').append(response.htmlPaginator);
                        }
                        parseEmojiComment();
                    } else {
                        alertArea.removeClass('hidden').append('<ul><li>' + response.message + '</li></ul>');
                    }
                }
            });
        }
    });

    $('body').on('click', '.comment-reply-panel', function () {
        $(this).parents('li').find('.comment-reply-container').css('display', 'block');
    });

    $('body').on('keydown', '.reply-comment-input', function (e) {
        if (e.which == 13) {
            var form = $(this).parents('.comment-to-top');
            var data = form.serialize();
            var input = form.find('.reply-comment-input');
            var alertArea = $(this).parents('.comment-posting-form').find('.alert-danger:first');
            alertArea.addClass('hidden').html('');
            var commentsListArea = $(this).parents('.comment-reply-container').find('.media-list-comments-replies');

            if (input.val() != '') {
                $.ajax({
                    'url': '/comments',
                    'type': 'POST',
                    'data': data,
                    success: (response) => {
                        if (response.success) {
                            input.val('');
                            commentsListArea.append('<li class="media no-overflow-hidden">' + response.htmlComments + '</li>');
                            $('.comment-count').html(response.total);
                            var reply = commentsListArea.find('li:last').find('.comment-body.text-comment');
                            reply.html(twemoji.parse(reply.text()));
                        } else {
                            alertArea.removeClass('hidden').html('').append('<ul><li>' + response.message + '</li></ul>');
                        }
                    }
                });
            }

            return false;
        }
    });

    $('body').on('click', '.btn-delete', function () {
        var thisModal = $('#delete-comment-modal');
        var commentId = $(this).attr('data-id');
        thisModal.modal('show');
        thisModal.find('.confirm-delete').attr('data-comment-id', commentId);
    });

    $('.confirm-delete').on('click', function () {
        $('#delete-comment-modal').modal('hide');
        var commentId = $(this).attr('data-comment-id');
        $('#delete-comment-modal').find('.confirm-delete').attr('data-comment-id', '');
        var alertArea = $('.comment-posting-form').find('.alert-danger:first');
        alertArea.addClass('hidden').html('');
        $('.comments-list').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');

        $.ajax({
            'url': '/comments/' + commentId,
            'type': 'DELETE',
            'data': {},
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: (response) => {
                if (response.success) {
                    $('.comments-list').html('').append(response.htmlComments);
                    $('.comment-count').html(response.total);
                    $('.comment-pagination').html('').append(response.htmlPaginator);
                    parseEmojiComment();
                } else {
                    alertArea.removeClass('hidden').append('<ul><li>' + response.message + '</li></ul>');
                    $('html, body').animate({
                        scrollTop: $('.comment-posting-form').offset().top
                    }, 700);
                }
            }
        });
    });

    $('body').on('click', '.comment-area .pagination a', function (e) {
        e.preventDefault();
        $('.comment-posting-form').find('.alert-danger:first').addClass('hidden').html('');
        var page = $(this).attr('href').split('page=')[1];
        getItems('/comments/lists/' + articleId + '/' + articleLocaleId + '?page=' + page);
    });

    $('body').on('click', '.engagement-favorite.engagement-interactive', function () {
        var commentId = $(this).attr('data-comment-id');
        var alertArea = $('.comment-posting-form').find('.alert-danger:first');
        alertArea.addClass('hidden').html('');
        var favoriteArea = $(this).parents('.comment-favorite');

        $.ajax({
            'url': '/comments/favorite/' + commentId,
            'type': 'GET',
            success: (response) => {
                if (response.success) {
                    var favoriteCount = parseInt(favoriteArea.find('.engagement-count').text());

                    if (favoriteArea.find('.fa-heart').hasClass('active')) {
                        favoriteArea.find('.fa-heart').removeClass('active').addClass('disabled');
                        favoriteArea.find('.engagement-count').text(favoriteCount - 1);
                    } else {
                        favoriteArea.find('.fa-heart').removeClass('disabled').addClass('active');
                        favoriteArea.find('.engagement-count').text(favoriteCount + 1);
                    }
                } else {
                    alertArea.removeClass('hidden').append('<ul><li>' + response.message + '</li></ul>');
                    $('html, body').animate({
                        scrollTop: $('.comment-posting-form').offset().top
                    }, 700);
                }
            }
        });
    });
});

function searchGif() {
    var keyword = $('#search-gif-input').val();

    if (keyword) {
        $.ajax({
            'url': 'https://api.tenor.co/v1/search?tag=' + keyword + '&key=LIVDSRZULELA',
            'type': 'GET',
            'data': {},
            success: (data) => {
                $('#gifs-search-block .body-result-gifs').html('');
                $.each(data.results, function(key, value) {
                    $('#gifs-search-block .body-result-gifs').append('<img class="gif-image" alt="" src="' + value.media[0]['gif']['url'] + '">');
                });
            }
        });
    }
}

function getEmoji(dataCategory) {
    var thisEmojiSection = $('#emoji-picker-block .body-twitter-emoji-list.' + dataCategory);
    if (thisEmojiSection.hasClass('emoji-loaded')) {
        return;
    }

    thisEmojiSection.find('li').each(function () {
        var emoji = twemoji.parse($(this).text());
        $(this).html(emoji);
    });

    thisEmojiSection.addClass('emoji-loaded');
}

function parseEmojiComment() {
    $('body').find('.comment-body').each(function () {
        if ($(this).hasClass('text-comment')) {
            var emoji = twemoji.parse($(this).text());
            $(this).html(emoji);
        }
    });
}

function getItems(url, firstTime) {
    $('.comments-list').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');

    $.ajax({
        'url': url,
        'type': 'GET',
        success: (response) => {
            if (response.success) {
                $('.comments-list').html('').append(response.htmlItems);
                $('.comment-pagination').html('').append(response.htmlPaginator);
                parseEmojiComment();

                if (!firstTime) {
                    $('html, body').animate({
                        scrollTop: $('.comment-posting-form').offset().top
                    }, 700);
                }
            }
        }
    });
}

function getEmojiPopup(element) {
    var popupArea = element.parents('.form-comment').find('.popup-emoticon');

    $.ajax({
        'url': '/comments/getEmoji',
        'type': 'GET',
        success: (response) => {
            popupArea.html('').append(response);
            $('#emoji-picker-block').css('display', 'block');
            getEmoji('people');
        }
    });
}
