$(function () {

    //総件数表示
    MPF.api.article.comment.getArticleComments({ $count: true, $top: 0, $filter: 'ArticleId eq ' + MPF.current.itemId + ' and ParentCommentId eq null' + ' and Country eq ' + '\'' + MPF.current.country + '\'' })
    .done(function (odata) {
        $('span.comment-count').text(odata['@odata.count']);
    });

    //初期表示
    loadArticleComments(MPF.current.itemId, $('.comment-area .media-list-comments'), 5);

    //set default emoji size
    twemoji.size = '36x36';

    //GIF button
    $('.show-gifs-selection').click(function () {
        $('#gif-for-parent-comment-id').val($(this).closest('li.media[data-article-comment-id]').attr('data-article-comment-id'));
        if (!($(this).next().hasClass('gifs-comment-block'))) {
            //$('#gifs-search-block').appendTo($(this).parent());
            $('#gifs-search-block').insertAfter($(this));
        }

        var offset = $(this).offset();
        var buttonToTop = offset.top - $(window).scrollTop();
        var searchBlockHeight = $('#gifs-search-block').height();

        if (buttonToTop < searchBlockHeight) {
            $('#gifs-search-block').css('bottom', 2 - $('#gifs-search-block').outerHeight() + 'px');
        } else {
            $('#gifs-search-block').css('bottom', $(this).parent().height() + 'px');
        }

        $(this).next().fadeIn(50);

        $('#gifs-search-block #search-gif-input').focus();
        getGifsBySearchKeyword($('#gifs-search-block #search-gif-input').val());
    });

    // Close gif keyboard
    $('#close-gif-popup-btn').click(function () {
        $('#gifs-search-block').fadeOut(50);
    });

    //TwitterEmoji button
    $('.btn-twemoji').click(function () {
        if ($('#emoji-picker-block .popup-gif').length == 0) {
            $.ajax({
                url: '/api/sitecore/Article/GetTwitterEmojiPopup',
                type: 'GET',
                success: function (data) {
                    $('#emoji-picker-block').html(data);
                    twemoji.parse($('#emoji-picker-block').get(0));

                    // On swich category twitter emoji
                    $('#emoji-picker-block .popup-gif .category-menu-emoji-list span').click(function () {
                        var oldActiveCategory = $('#emoji-picker-block .popup-gif .category-menu-emoji-list span.active');
                        oldActiveCategory.removeClass('active');
                        $('#emoji-picker-block .popup-gif .body-twitter-emoji-list.' + oldActiveCategory.attr('data-category')).addClass('hidden');
                        $(this).addClass('active');
                        $('#emoji-picker-block .popup-gif .body-twitter-emoji-list.' + $(this).attr('data-category')).removeClass('hidden');
                    });
                }
            });
        }

        $('#emoji-picker-block #emoji-for-parent-comment-id').val($(this).closest('li.media[data-article-comment-id]').attr('data-article-comment-id'));
        if (!($(this).next().hasClass('gifs-comment-block'))) {
            $('#emoji-picker-block').insertAfter($(this));
        }

        var offset = $(this).offset();
        var buttonToTop = offset.top - $(window).scrollTop();
        var searchBlockHeight = $('#emoji-picker-block').height();

        if (buttonToTop < searchBlockHeight) {
            $('#emoji-picker-block').css('bottom', 2 - $('#emoji-picker-block').outerHeight() + 'px');
        } else {
            $('#emoji-picker-block').css('bottom', $(this).parent().height() + 'px');
        }

        $(this).next().fadeIn(50);
        $('#emoji-picker-block #search-twemoji-input').focus();
    });

    // On press Enter, get gifs by input
    $('#gifs-search-block #search-gif-input').keypress(function (e) {
        if (e.which == 13) {
            $('.body-result-gifs').html('');
            var input = $(this).val();
            getGifsBySearchKeyword(input);
            e.preventDefault();
            return false;
        }
    });

    // On click button search on gif keyboard
    $('#gifs-search-block #search-gif-btn').click(function () {
        getGifsBySearchKeyword($('#gifs-search-block #search-gif-input').val());
    });

    // On resize windows
    $(window).resize(function () {
        if ($('#gifs-search-block').is(":visible")) {
            $('#gifs-search-block').fadeOut(50);
        }
    });

    // Close gif keyboard on click outside it
    $(document).mouseup(function (e) {
        var container = $('#gifs-search-block');
        var twitterEmojiContainer = $('#emoji-picker-block');

        if (!container.is(e.target)
            && container.has(e.target).length === 0) {
            container.fadeOut(50);
        }

        if (!twitterEmojiContainer.is(e.target)
            && twitterEmojiContainer.has(e.target).length === 0) {
            twitterEmojiContainer.fadeOut(50);
        }
    });

    var gif;

    //Show modal confirm for gif comment
    $('.gifs-comment-block').on('click', '.gif-image', function () {
        gif = $(this);
        $('#gifs-search-block').fadeToggle(50);
        $('#confirm-gif-modal').modal('show');
    });

    //Show modal confirm for emoji comment
    $('#emoji-picker-block').on('click', 'li img.emoji', function () {
        var twitterIcon = $(this).attr('alt');
        var textarea = $(this).closest('form').find('textarea');
        var textarea = $(this).closest('form').find('textarea');
        textarea.val(textarea.val() + twitterIcon);
    });

    //textare comment posting autoresize
    $(".comment-area textarea").on('keyup', function () {
        var offset = this.offsetHeight - this.clientHeight;
        $(this).css('height', 'auto').css('height', this.scrollHeight + offset);
    });

    //POST Gif image comment
    $('#confirm-gif-modal .modal-footer .btn-primary').click(function () {
        var modalElement = $('#confirm-gif-modal');
        var gif_height = parseInt(gif.attr('data-height'));
        var gif_width = parseInt(gif.attr('data-width'));

        var max_height = 11;//parseInt(MPF.config.gif.maxHeightGifComment);
        if (gif_height > max_height) {
            gif_width = gif_width * max_height / gif_height;
            gif_height = max_height;
        }

        gif.attr('height', gif_height + 'px');
        gif.attr('width', gif_width + 'px');

        $('#confirm-gif-modal').modal('hide');
        postGifComment(gif.get(0).outerHTML);
    });

    // 投稿ボタン
    $('.comment-posting-form button').click(function () {
        var postButton = $(this);

        postButton.closest('.comment-area').find('.no-match-message').remove();

        var messageTextarea = postButton.closest('form').find('textarea');
        var message = messageTextarea.val();

        if (message.length == 0)
            return;

        postButton.prop('disabled', true);

        // 親コメントIDを取得する。
        var parentCommentId = postButton.closest('li.media[data-article-comment-id]').attr('data-article-comment-id');

        MPF.api.article.comment.postArticleComment(MPF.current.itemId, MPF.current.country, message, parentCommentId)
        .done(function (data) {
            messageTextarea.val('');
            postButton.closest('.comment-posting-form').find('.alert').addClass('hidden').find('ul > li').addClass('hidden');

            // 投稿したコメントを表示する。
            var commentContainer = postButton.closest('.comment-posting-form').parent().find('> .media-list-comments');

            data.Stats = { LikeCount: 0, ReplyCount: 0 };
            var element = buildArticleCommentEntry(data).hide();

            // 投稿したコメントは常に削除可能なので削除ボタンを表示する。
            element.find('.btn-delete').show();

            if (!parentCommentId) {
                commentContainer.prepend(element.find('.comment-reply-panel').show().end());

                // コメント数を調整する。
                var countElement = commentContainer.closest('.comment-area').find('span.comment-count');
                var count = parseInt(countElement.text()) + 1;
                countElement.text(count);
            }
            else {
                commentContainer.append(element.find('.comment-reply-panel').remove().end());
            }

            element.slideDown(400);
        })
        .fail(function (jqXHR) {
            if (jqXHR.status == 503) {
                postButton.closest('.comment-posting-form').find('.alert').removeClass('hidden').find('ul > li:nth-child(1)').removeClass('hidden');
            }
            if (jqXHR.status == 400) {
                postButton.closest('.comment-posting-form').find('.alert').removeClass('hidden').find('ul > li:nth-child(2)').removeClass('hidden');
            }
            if (jqXHR.status == 403) {
                postButton.closest('.comment-posting-form').find('.alert').removeClass('hidden').find('ul > li:nth-child(3)').removeClass('hidden');
            }
        })
        .always(function () {
            postButton.prop('disabled', false);
        });


        // //TEST
        // var data = {
        //     "@odata.context":"https://indonesia.fun-japan.jp/odata/$metadata#ArticleComments/$entity","@odata.etag":"W/\"YmluYXJ5J0FBQUFBQUNCUmkwPSc=\"","Id":"bd224bf0-9a6b-4bb3-b5aa-f0b270500a41","Country":"id-id","ArticleId":"6bd0be0a-dbe0-4fc3-9694-1aecbf418700","PostedBy":"c57da835-fa52-4b35-9814-85ae9c43c098","Message":"i like it","ParentCommentId":null,"PostedDate":"2016-12-19T06:38:30.4842598Z","Timestamp":"AAAAAACBRi0="
        // };

        // // var data = {
        // //   "@odata.context":"https://indonesia.fun-japan.jp/odata/$metadata#ArticleComments/$entity","@odata.etag":"W/\"YmluYXJ5J0FBQUFBQUNCUnE0PSc=\"","Id":"0d292aa7-5c67-4c34-9eee-f941d4b4166d","Country":"id-id","ArticleId":"6bd0be0a-dbe0-4fc3-9694-1aecbf418700","PostedBy":"c57da835-fa52-4b35-9814-85ae9c43c098","Message":"dg\ud83d\ude1a","ParentCommentId":null,"PostedDate":"2016-12-19T08:09:11.468381Z","Timestamp":"AAAAAACBRq4="
        // // }

        // // var data = {
        // //     "@odata.context":"https://indonesia.fun-japan.jp/odata/$metadata#ArticleComments/$entity","@odata.etag":"W/\"YmluYXJ5J0FBQUFBQUNCUnFNPSc=\"","Id":"78195dca-a8f1-48e9-99ae-a55de2c6513b","Country":"id-id","ArticleId":"6bd0be0a-dbe0-4fc3-9694-1aecbf418700","PostedBy":"c57da835-fa52-4b35-9814-85ae9c43c098","Message":"<img class=\"gif-image\" alt=\"\" src=\"https://media.tenor.co/images/8e152ffa5c21618e19f741e4c3abfb22/raw\" data-width=\"490\" data-height=\"442\" height=\"150px\" width=\"166.289592760181px\">","ParentCommentId":null,"PostedDate":"2016-12-19T08:04:46.8582166Z","Timestamp":"AAAAAACBRqM="
        // // }

        // messageTextarea.val('');
        // postButton.closest('.comment-posting-form').find('.alert').addClass('hidden').find('ul > li').addClass('hidden');

        // // 投稿したコメントを表示する。
        // var commentContainer = postButton.closest('.comment-posting-form').parent().find('> .media-list-comments');


        // data.Stats = { LikeCount: 4, ReplyCount: 2 };
        // var element = buildArticleCommentEntry(data).hide();

        // // 投稿したコメントは常に削除可能なので削除ボタンを表示する。
        // element.find('.btn-delete').show();

        // if (!parentCommentId) {
        //     commentContainer.prepend(element.find('.comment-reply-panel').show().end());

        //     // コメント数を調整する。
        //     var countElement = commentContainer.closest('.comment-area').find('span.comment-count');
        //     var count = parseInt(countElement.text()) + 1;
        //     countElement.text(count);
        // }
        // else {
        //     commentContainer.append(element.find('.comment-reply-panel').remove().end());
        // }

        // element.slideDown(400);
    });

    //Comment pagination
    $('.comment-pagination li > a').click(function () {
        var commentIndex = parseInt($(this).text());
        var skip = commentIndex * 5;
        loadArticleComments(MPF.current.itemId, $('.comment-area > .media-list-comments'), 5, false, false,skip);
    });
});

// コメントを読み込む
function loadArticleComments(articleId, commentContainer, top, append, isCount, skip=0) {
    var deferred = $.Deferred();

    $('.comment-area').find('.no-match-message').remove();

    var isReplyComment = commentContainer.hasClass('media-list-comments-replies');

    var parentCommentId = isReplyComment
        ? commentContainer.closest('li.media[data-article-comment-id]').attr('data-article-comment-id')
        : null;

    //var skip = append ? commentContainer.find('> li').length : 0; // 表示されているコメント数を取得する。    

    //ユーザー検索に値があれば、ユーザー名でフィルターをかける
    var userNameQuery = '';
    if (!isReplyComment) {
        var searchUserName = $.trim(commentContainer.closest('.comment-area').find('.comment-search-form').find('input').val());
        if (searchUserName != '') {
            userNameQuery = ' and contains(Author/DisplayName,\'' + searchUserName + '\')';
        };
    };

    //Sort順を取得
    var orderby = 'PostedDate desc';
    if (!isReplyComment) {
        switch (commentContainer.closest('.comment-area').find('ul.comment-sort-list').attr('data-comment-sort')) {
            case 'Newest':
                orderby = 'PostedDate desc';
                break;

            case 'Oldest':
                orderby = 'PostedDate asc'
                break;

            case 'Popular':
                orderby = 'Stats/LikeCount desc, PostedDate desc';
                break;
        };
    };

    var options = {
        //readmore表示、非表示の制御のため、指定された件数より1件多く取得する
        $top: isReplyComment ? top : top + 1,
        $skip: skip,
        $expand: 'Stats',
        $filter: 'ArticleId eq ' + articleId + ' and ParentCommentId eq ' + parentCommentId + ' and Country eq ' + '\'' + MPF.current.country + '\'' + userNameQuery,
        $count: isCount ? true : false,
        $orderby: orderby
    };


    MPF.api.article.comment.getArticleComments(options)
    .done(function (data) {
        var entries = $('<ul></ul>');

        if (!append)
            commentContainer.empty();

        var dataValue = data.value;

        //返信欄は投稿日時の昇順
        if (isReplyComment) {
            dataValue = dataValue.reverse();
        } else {
            // 取得したコメント数が、指定件数に満たない場合、read moreを非表示にする。
            if (dataValue.length <= top) {
                commentContainer.closest('.comment-area').find('.comment-more').hide();
            } else {
                commentContainer.closest('.comment-area').find('.comment-more').show();
                //表示時には、1件多く取得したデータを取り除く
                dataValue.pop();
            }
        }

        $.each(dataValue, function (i, articleComment) {
            // 既に表示されているコメントはスキップする。
            if (commentContainer.find('> li[data-article-comment-id="' + articleComment.Id + '"]').length > 0)
                return;

            entries.append(buildArticleCommentEntry(articleComment));
        });

        commentContainer.append(entries.children());

        if (isReplyComment) {
            commentContainer.find('.comment-reply-panel').remove();
        }


        commentContainer.find('li[data-article-comment-owner]')
            .each(function () {
                var comment = $(this);
                //コメント、または親コメントがユーザーの場合、コメント削除可能
                if (comment.data('article-comment-owner') || comment.parents('li.media[data-article-comment-owner]').data('article-comment-owner') || MPF.current.user.isAdmin) {
                    comment.find('.btn-delete').show();
                };
            });

        deferred.resolve(data);
    })
    .fail(function (jqXHR) {
        deferred.reject(jqXHR);
    });

    return deferred.promise();
};

// コメント1件分のDOMを作成する
function buildArticleCommentEntry(articleComment) {
    var template = 
    `<li class="media no-overflow-hidden">
        <div class="pull-left profile-picture" style="position:relative">
            <img class="media-object img-circle">
        </div>
        <div class="media-body">
            <p class="h4 media-heading"></p>
            <div class="pull-right">
                <a class="btn-delete" href="javascript: void(0);">delete</a>
            </div>
            <p class="comment-body"></p>
            <p class="time">
                <span class="post-text">Posted at </span><span class="post-date"></span>
                <a  class="comment-reply-panel" href="javascript:void(0);"><i class="fa fa-reply-all"></i></a>
            </p>
        </div>        
        <div class="comment-favorite">
            <a class="engagement-favorite" href="javascript:void(0);">
                <i class="fa fa-heart"></i>
            </a>
            <span class="engagement-count"></span>
        </div>
    </li>`;

    var messageContent = twemoji.parse(articleComment.Message);

    var element = $(template).attr('data-article-comment-id', articleComment.Id).attr('data-article-comment-owner', (articleComment.PostedBy == MPF.current.user.userId) ? true : false)
        .find('.post-date').text(new Date(articleComment.PostedDate).toLocaleString()).end()
        .find('.comment-body').html(messageContent).end()
        .find('.engagement-count').text(articleComment.Stats.LikeCount).end()
        .find('.btn-delete').hide().end();

    // 投稿者のユーザープロファイルを読み込む
    MPF.getPublicUserProfile(articleComment.PostedBy)
    .done(function (profile) {
        element.find('.media-heading').text(profile.DisplayName).end();
        var mediaObject = element.find('.media-object');
        mediaObject.attr('src', profile.PictureUrl).attr('alt', profile.DisplayName).end();

        if ((articleComment.PostedBy == MPF.current.user.userId) && !profile.PictureUrl.match(/facebook/)) {
            mediaObject.wrap('<a class="text-center" href="https://gravatar.com/" target="_blank"></a>').end();
            mediaObject.after('<span><i class="fa fa-plus-square"></i> Picture</span>').end();
        };

    })
    .fail(function (jqXHR) {
        if (jqXHR.status == 404) {
            element
                .find('.media-heading').text('(Someone)').end()
                .find('.media-object').attr('src', '/mpf/images/no-profile-picture.png').attr('alt', '(Someone)').end();
        };
    });

    // 返信がある場合は返信ボタンを有効にする
    if (articleComment.Stats.ReplyCount >= 1) {
        element.find('.comment-reply-panel').html('<i class="fa fa-reply-all"></i> ' + '<span class="reply-count">' + articleComment.Stats.ReplyCount + '</span>');
    }

    // Like押下済みの場合、Activeにする
    MPF.api.article.comment.isCommentLiked(articleComment.Id)
    .done(function (data) {
        if (data.value)
            element.find('.comment-favorite > a > i').addClass('active');
    });

    // Likeのクリックイベント設定
    element.find('comment-favorite')
        .click(function () {
            var button = $(this);

            if (button.hasClass('disabled')) {
                return false;
            };

            button.addClass('disabled');

            if (MPF.current.user.isAuthenticated) {
                MPF.api.article.comment.toggleLike(articleComment.Id)
                .done(function (odata) {
                    // Like数を更新する
                    MPF.api.article.comment.getArticleComments({ $filter: 'Id eq ' + articleComment.Id, $expand: 'Stats' })
                    .done(function (d) {
                        button.children('span.engagement-count').text(d.value[0].Stats.LikeCount);

                        if (odata.value) {
                            button.addClass('active');
                        } else {
                            button.removeClass('active');
                        };

                        button.removeClass('disabled');
                    });
                });
            } else {
                location.href = MPF.getLoginUrl();
            };
        });

    // 削除ボタンのイベント設定
    element.find('.btn-delete').click(function () {
        if ($('#comment-area').find('#gifs-search-block').length == 1) {
            $('#gifs-search-block').insertAfter($('#comment-area'));
        }

        if ($('#comment-area').find('#emoji-picker-block').length == 1) {
            $('#emoji-picker-block').insertAfter($('#comment-area'));
        }

        $(this).addClass('disabled');

        var modalElement = $(this).closest('.comment-area').find('div#delete-comment-modal');

        modalElement.modal('show');

        modalElement.on('click', '.modal-footer .btn-primary', function () {
            modalElement.modal('hide');

            modalElement.off('click');

            MPF.api.article.comment.deleteArticleComment(articleComment.Id)
            .always(function () {
                element.slideUp(400, function () {
                    $(this).remove();
                });

                if (!articleComment.ParentCommentId) {
                    // コメント数を調整する。
                    var countElement = element.closest('.comment-area').find('span.comment-count');
                    var count = parseInt(countElement.text(), 10) - 1;
                    countElement.text(count);
                };
            });
        });
    });

     // TODO: CHANGE reply input Write a reply
    element.find('.comment-reply-panel')
        .click(function () {
            var count = parseInt(articleComment.Stats.ReplyCount) - 2;
            var replyContainer = $('<div class="comment-reply-container"><ul class="media-list media-list-comments media-list-comments-replies"></ul></div>')
                .append($(this).closest('.comment-area').find('.comment-reply-form').clone(true).css("display", "block"));

            replyContainer.find('.comment-posting-form .alert').addClass('hidden');
            replyContainer.find('.comment-posting-form').parent().find('> .comment-reply-panel').addClass('hidden');

            replyContainer.find('.comment-posting-form').find('textarea').attr('placeholder', 'Write reply...').end()
            .find('button.btn').text('Post reply').end();

            $(this).closest('li.media').append(replyContainer);
            $(this).closest('.comment-reply-panel').remove();

            loadArticleComments(MPF.current.itemId, replyContainer.find('> .media-list-comments'), 2, false, true)
                            .done(function (data) {
                                var dataCount = parseInt(data['@odata.count']) - 2;
                                if (dataCount > 0) {
                                    replyContainer.find('.comment-posting-form').parent().find('.comment-reply-panel').removeClass('hidden')
                                    .text('View all replies (' + dataCount + ')');
                                };
                            });

            // View all Reply
            replyContainer.find('.comment-reply-panel')
                .click(function () {
                    var viewAllReplyButton = $(this)
                    loadArticleComments(MPF.current.itemId, replyContainer.find('.media-list-comments'), undefined, false, true)
                               .done(function (data) {
                                   viewAllReplyButton.hide();
                               });
                });

        });

    return element;
};

function getGifsBySearchKeyword(input) {
    //$('.body-result-gifs').html('');
    var serviceUrl;
    if (input) {
        serviceUrl = MPF.getGifsBySearchTerm(input);
    }
    else {
        serviceUrl = MPF.getTrendingGifsRequestUrl();
    }

    getGifsResultsFromAPI(serviceUrl);
}

function getGifsResultsFromAPI(serviceUrl) {
    $.get(serviceUrl, function (data) {
        $('.body-result-gifs').empty();
        $.each(data.results, function (index, obj) {
            var img = $('<img class="gif-image" alt="">');
            img.attr('src', obj.media[0].gif.url);
            img.attr('data-width', obj.media[0].gif.dims[0]);
            img.attr('data-height', obj.media[0].gif.dims[1]);
            img.appendTo('.body-result-gifs');
        });
    });
}


function postGifComment(message) {
    var postButton;

    // 親コメントIDを取得する。
    var parentCommentId = $('#gif-for-parent-comment-id').val();

    if (parentCommentId != null && parentCommentId != undefined && parentCommentId != "") {
        postButton = $('li.media[data-article-comment-id=' + parentCommentId + ']').find('button');
    }
    else {
        postButton = $('.comment-posting-form').first().find('button');
    }

    postButton.prop('disabled', true);
    var messageTextarea = postButton.closest('form').find('textarea');

    MPF.api.article.comment.postArticleComment(MPF.current.itemId, MPF.current.country, message, parentCommentId)
    .done(function (data) {
        messageTextarea.val("");
        postButton.closest('.comment-posting-form').find('.alert').addClass('hidden').find('ul > li').addClass('hidden');

        // 投稿したコメントを表示する。
        var commentContainer = postButton.closest('.comment-posting-form').parent().find('> .media-list-comments');

        data.Stats = { LikeCount: 0, ReplyCount: 0 };
        var element = buildArticleCommentEntry(data).hide();

        // 投稿したコメントは常に削除可能なので削除ボタンを表示する。
        element.find('.btn-delete').show();

        if (!parentCommentId) {
            commentContainer.prepend(element.find('.comment-reply-panel').show().end());

            // コメント数を調整する。
            var countElement = commentContainer.closest('.comment-area').find('span.comment-count');
            var count = parseInt(countElement.text()) + 1;
            countElement.text(count);
        }
        else {
            commentContainer.append(element.find('.comment-reply-panel').remove().end());
        }

        element.slideDown(400);
    })
    .fail(function (jqXHR) {
        if (jqXHR.status == 503) {
            postButton.closest('.comment-posting-form').find('.alert').removeClass('hidden').find('ul > li:nth-child(1)').removeClass('hidden');
        }
        if (jqXHR.status == 400) {
            postButton.closest('.comment-posting-form').find('.alert').removeClass('hidden').find('ul > li:nth-child(2)').removeClass('hidden');
        }
        if (jqXHR.status == 403) {
            postButton.closest('.comment-posting-form').find('.alert').removeClass('hidden').find('ul > li:nth-child(3)').removeClass('hidden');
        }
    })
    .always(function () {
        postButton.prop('disabled', false);
    });
}
