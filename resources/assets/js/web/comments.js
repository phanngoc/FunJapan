$(function () {
    parseEmojiComment();

    $(window).on('click', function() {
        $('#emoji-picker-block').css('display', 'none');
        $('#gifs-search-block').css('display', 'none');
        $('.popup-emoticon').html('');
        $('.popup-gif-search').html('');
    });

    $('body').on('click', '.gifs-comment-block', function (event) {
        event.stopPropagation();
    });

    $('body').on('click', '#emoji-picker-block', function (event) {
        event.stopPropagation();
    });

    $('body').on('click', '.btn-twemoji', function (event) {
        event.stopPropagation();
        var emojiPicker = $('#emoji-picker-block');

        if (emojiPicker.css('display') == 'block') {
            emojiPicker.css('display', 'none');
            $('.popup-emoticon').html('');
        } else {
            $('body').find('#gifs-search-block').css('display', 'none');
            getEmojiPopup($(this));
        }
    });

    $('body').on('click', '.show-gifs-selection', function (event) {
        event.stopPropagation();
        getGifPopup($(this).parents('.comment-area'));

    });

    $('body').on('keydown', '#search-gif-input', function (e) {
        if (e.which == 13) {
            searchGif();
            return false;
        }
    });

    $('body').on('click', '#gifs-search-block #search-gif-btn', function () {
        searchGif();
    });

    $('body').on('click', '#close-gif-popup-btn', function () {
        $('#gifs-search-block').css('display', 'none');
    });

    $('body').on('click', '#gifs-search-block .body-result-gifs .gif-image', function () {
        var commentArea = $(this).parents('.comment-area');
        commentArea.find('form.form-gif-comment .comment-gif-input').val($(this).attr('src'));
        $('#confirm-gif-modal').find('img').attr('src', $(this).attr('src')).removeClass('hidden');
        var data = commentArea.find('form.form-gif-comment').serialize();
        var articleId = commentArea.attr('data-article-id');
        $('#confirm-gif-modal').find('.confirm-post-gif').attr('data-comment-gif', data);
        $('#confirm-gif-modal').find('.confirm-post-gif').attr('data-article-id', articleId);
        $('#confirm-gif-modal').modal('show');
        $('#gifs-search-block').css('display', 'none');
    });

    $('#confirm-gif-modal').on('click', '.confirm-post-gif', function () {
        $('#confirm-gif-modal').modal('hide');
        var data = $(this).attr('data-comment-gif');
        var articleId = $(this).attr('data-article-id');
        var commentArea = $('#article-body-' + articleId).find('.comment-area');
        $('#confirm-gif-modal').find('.confirm-post-gif').attr('data-comment-gif', '');
        $('#confirm-gif-modal').find('.confirm-post-gif').attr('data-article-id', '');
        $('#confirm-gif-modal').find('img').attr('src', '').addClass('hidden');
        var alertArea = commentArea.find('.comment-posting-form .alert-danger:first');
        alertArea.addClass('hidden').html('');
        commentArea.find('.comments-list').addClass('hidden');
        commentArea.find('.comments-loading').removeClass('hidden');

        $.ajax({
            'url': baseUrlLocale() + 'comments',
            'type': 'POST',
            'data': data,
            success: (response) => {
                commentArea.find('.comments-loading').addClass('hidden');
                commentArea.find('.comments-list').removeClass('hidden');

                if (response.success) {
                    commentArea.find('.comments-list').html('').append(response.htmlComments);
                    commentArea.find('.comment-count').html(response.total);
                    commentArea.find('.comment-pagination').html('').append(response.htmlPaginator);
                    parseEmojiComment();
                } else {
                    var message = '';
                    for (let key in response.message) {
                        message += '<ul><li>' + response.message[key] + '</li></ul>';
                    }

                    alertArea.removeClass('hidden').append(message);
                }

                $('#gifs-search-block').css('display', 'none');
            }
        });
    });

    $('body').on('click', '#emoji-picker-block .popup-content li', function (event) {
        event.stopPropagation();
        var input = $(this).parents('.form-comment').find('.comment-input');
        input.val(input.val() + $(this).find('img').attr('alt'));
    });

    $('body').on('click', '.category-menu-emoji-list span', function (event) {
        event.stopPropagation();
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

    $('body').on('click', '.send-comment', function () {
        postComment($(this));
    });

    $('body').on('keydown', '.post-comment', function (e) {
        if (e.which == 13) {
            if ($(this).val() != '') {
                postComment($(this));
            }

            e.preventDefault();
        }
    });

    $('body').on('click', '.comment-reply-panel', function () {
        // $(this).parents('ul').find('.comment-reply-container').css('display', 'none');
        $(this).parents('li').find('.comment-reply-container').css('display', 'block');
    });

    $('body').on('click', '.show-comment', function () {
        var currentArea = $(this).parents('.body-comment');
        currentArea.find('.limited-text').addClass('hidden');
        $(this).addClass('hidden');
        currentArea.find('.full-text').removeClass('hidden');
    });

    $('body').on('keydown', '.reply-comment-input', function (e) {
        if (e.which == 13) {
            var form = $(this).parents('.comment-to-top');
            var data = form.serialize();
            var input = form.find('.reply-comment-input');
            var alertArea = $(this).parents('.comment-reply-container').find('.alert-danger:first');
            alertArea.addClass('hidden').html('');
            var commentsListArea = $(this).parents('.comment-reply-container').find('.media-list-comments-replies');
            var currentParrentComment = $(this).parents('.parent-comment');

            if (input.val() != '') {
                $.ajax({
                    'url': baseUrlLocale() + 'comments',
                    'type': 'POST',
                    'data': data,
                    success: (response) => {
                        if (response.success) {
                            input.val('');
                            commentsListArea.append('<li class="media no-overflow-hidden">' + response.htmlComments + '</li>');
                            currentParrentComment.find('.comment-reply-panel .reply-count').html(response.total);
                            var reply = commentsListArea.find('li:last').find('.comment-body.text-comment');
                            reply.each(function () {
                                $(this).html(twemoji.parse($(this).html()));
                            });
                        } else {
                            var message = '';

                            for (let key in response.message) {
                                message += '<p>' + response.message[key] + '</p>';
                            }

                            alertArea.removeClass('hidden').html('').append('<ul><li>' + message + '</li></ul>');
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
        var articleId = $(this).attr('data-article-id')
        thisModal.modal('show');
        thisModal.find('.confirm-delete').attr('data-comment-id', commentId);
        thisModal.find('.confirm-delete').attr('data-article-id', articleId);
    });

    $('.confirm-delete').on('click', function () {
        var thisModal = $('#delete-comment-modal');
        thisModal.modal('hide');
        var commentId = $(this).attr('data-comment-id');
        var articleId = $(this).attr('data-article-id');
        thisModal.find('.confirm-delete').attr('data-comment-id', '');
        thisModal.find('.confirm-delete').attr('data-comment-id', '');
        var commentArea = $('#article-body-' + articleId).find('.comment-area');
        var alertArea = commentArea.find('.comment-posting-form .alert-danger:first');
        alertArea.addClass('hidden').html('');
        commentArea.find('.comments-list').addClass('hidden');
        commentArea.find('.comments-loading').removeClass('hidden');

        $.ajax({
            'url': baseUrlLocale() + 'comments/' + commentId,
            'type': 'DELETE',
            'data': {},
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: (response) => {
                commentArea.find('.comments-loading').addClass('hidden');
                commentArea.find('.comments-list').removeClass('hidden');

                if (response.success) {
                    commentArea.find('.comments-list').html('').append(response.htmlComments);
                    commentArea.find('.comment-count').html(response.total);
                    commentArea.find('.comment-pagination').html('').append(response.htmlPaginator);
                    parseEmojiComment();
                } else {
                    alertArea.removeClass('hidden').append('<ul><li>' + response.message + '</li></ul>');
                    $('html, body').animate({
                        scrollTop: commentArea.find('.comment-posting-form').offset().top
                    }, 700);
                }
            }
        });
    });

    $('body').on('click', '.comment-area .pagination a', function (e) {
        e.preventDefault();
        if ($(this).parents('li').hasClass('disabled')) {
            return;
        }

        $('.comment-posting-form').find('.alert-danger:first').addClass('hidden').html('');
        var element = $(this).parents('.comment-area');
        var page = $(this).attr('href').split('page=')[1];
        var url = baseUrlLocale() + 'comments/lists/' + element.attr('data-article-id') + '?page=' + page;
        getItems(element, url);
    });

    $('body').on('click', '.engagement-favorite.engagement-interactive', function () {
        var commentId = $(this).attr('data-comment-id');
        var currentArea = $(this).parents('.comment-area');
        var alertArea = currentArea.find('.alert-danger:first');
        alertArea.addClass('hidden').html('');
        var favoriteArea = $(this).parents('.comment-favorite');

        $.ajax({
            'url': baseUrlLocale() + 'comments/favorite/' + commentId,
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
                        scrollTop: currentArea.offset().top
                    }, 700);
                }
            }
        });
    });
});

function postComment(element) {
    var currentArea = element.parents('.comment-area');
    var data = currentArea.find('form.form-create-comment').serialize();
    var alertArea = currentArea.find('.alert-danger:first');
    alertArea.addClass('hidden').html('');

    if (currentArea.find('.comment-input').val() != '') {
        currentArea.find('.comments-list').addClass('hidden');
        currentArea.find('.comments-loading').removeClass('hidden');
        element.attr('disabled', true);

        $.ajax({
            'url': baseUrlLocale() + 'comments',
            'type': 'POST',
            'data': data,
            success: (response) => {
                element.attr('disabled', false);

                if (response.success) {
                    currentArea.find('.comment-input').val('');
                    currentArea.find('.comments-list').removeClass('hidden').html('').append(response.htmlComments);
                    currentArea.find('.comments-loading').addClass('hidden');
                    currentArea.find('.comment-count').html(response.total);

                    if (response.htmlPaginator != '') {
                        currentArea.find('.comment-pagination').html('').append(response.htmlPaginator);
                    }

                    parseEmojiComment();
                } else {
                    var message = '';

                    for (let key in response.message) {
                        message += '<p>' + response.message[key] + '</p>';
                    }

                    currentArea.find('.comments-loading').addClass('hidden');
                    currentArea.find('.comments-list').removeClass('hidden');
                    alertArea.removeClass('hidden').append('<ul><li>' + message + '</li></ul>');
                }
            }
        });
    }
}

function searchGif() {
    var keyword = $('#search-gif-input').val();

    if (keyword) {
        $.ajax({
            'url': 'https://api.tenor.co/v1/search?tag=' + keyword + '&key=LIVDSRZULELA&limit=40',
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
        var emoji = twemoji.parse($(this).html());
        $(this).html(emoji);
    });

    thisEmojiSection.addClass('emoji-loaded');
}

function parseEmojiComment() {
    $('body').find('.comment-body').each(function () {
        if ($(this).hasClass('text-comment')) {
            var emoji = twemoji.parse($(this).html());
            $(this).html(emoji);
        }
    });
}

function getItems(element, url, firstTime) {
   element.find('.comments-list').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');

    $.ajax({
        'url': url,
        'type': 'GET',
        success: (response) => {
            if (response.success) {
                element.find('.comments-list').html('').append(response.htmlItems);
                element.find('.comment-pagination').html('').append(response.htmlPaginator);
                parseEmojiComment();

                if (!firstTime) {
                    $('html, body').animate({
                        scrollTop: element.offset().top
                    }, 700);
                }
            }
        }
    });
}

function getEmojiPopup(element) {
    var popupArea = element.parents('.form-comment').find('.popup-emoticon');

    $.ajax({
        'url': baseUrlLocale() + 'comments/getEmoji',
        'type': 'GET',
        success: (response) => {
            popupArea.html('').append(response);
            $('#emoji-picker-block').css('display', 'block');
            getEmoji('people');
        }
    });
}

function getGifPopup(element) {
    var popupArea = element.find('.popup-gif-search');
    var gifPicker = element.find('#gifs-search-block');

    if (gifPicker) {
        gifPicker.css('display', 'none');
        $('.popup-gif-search').html('');
    }

    $.ajax({
        'url': baseUrlLocale() + 'comments/getGif',
        'type': 'GET',
        success: (response) => {
            popupArea.html('').append(response);
            var gifPicker = element.find('#gifs-search-block');
            element.find('#search-gif-input').val('');
            gifPicker.css('display', 'block');
            $('#emoji-picker-block').css('display', 'none');

            $.ajax({
                'url': 'https://api.tenor.co/v1/trending?key=LIVDSRZULELA&limit=40',
                'type': 'GET',
                'data': {},
                success: (data) => {
                    popupArea.find('.body-result-gifs').html('');
                    $.each(data.results, function(key, value) {
                        popupArea.find('.body-result-gifs').append('<img class="gif-image" alt="" src="' + value.media[0]['gif']['url'] + '">');
                    });
                }
            });
        }
    });
}
