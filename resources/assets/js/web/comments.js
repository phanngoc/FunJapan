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
            var currentParrentComment = $(this).parents('.parent-comment');

            if (input.val() != '') {
                $.ajax({
                    'url': '/comments',
                    'type': 'POST',
                    'data': data,
                    success: (response) => {
                        if (response.success) {
                            input.val('');
                            commentsListArea.append('<li class="media no-overflow-hidden">' + response.htmlComments + '</li>');
                            currentParrentComment.find('.comment-reply-panel .reply-count').html(response.total);
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
        var element = $(this).parents('.comment-area');
        var page = $(this).attr('href').split('page=')[1];
        var url = '/comments/lists/' + element.attr('data-article-id') + '?page=' + page;
        getItems(element, url);
    });

    $('body').on('click', '.engagement-favorite.engagement-interactive', function () {
        var commentId = $(this).attr('data-comment-id');
        var currentArea = $(this).parents('.comment-area');
        var alertArea = currentArea.find('.alert-danger:first');
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
        currentArea.find('.comments-list').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');
        element.attr('disabled', true);
        currentArea.find('.comment-input').val('');

        $.ajax({
            'url': '/comments',
            'type': 'POST',
            'data': data,
            success: (response) => {
                element.attr('disabled', false);

                if (response.success) {
                    currentArea.find('.comments-list').html('').append(response.htmlComments);
                    currentArea.find('.comment-count').html(response.total);

                    if (response.htmlPaginator != '') {
                        currentArea.find('.comment-pagination').html('').append(response.htmlPaginator);
                    }

                    parseEmojiComment();
                } else {
                    alertArea.removeClass('hidden').append('<ul><li>' + response.message + '</li></ul>');
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
        'url': '/comments/getEmoji',
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
        'url': '/comments/getGif',
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
