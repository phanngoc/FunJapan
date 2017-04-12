
// コメントへのLike/Unlikeを切り替える
MPF.api.article.comment.toggleLike = function (commentId) {
    var deferred = $.Deferred();

    $.ajax({
        type: 'POST',
        url: MPF.config.api.baseUrl + 'odata/ArticleComments(' + commentId + ')/Default.ToggleLike',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken },
        success: deferred.resolve,
        error: deferred.reject
    });

    return deferred.promise();
};

// コメントを投稿する
MPF.api.article.comment.postArticleComment = function (articleId, country, message, parentCommentId) {
    var deferred = $.Deferred();

    $.ajax({
        type: 'POST',
        url: MPF.config.api.baseUrl + 'odata/ArticleComments',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken },
        data: {
            ArticleId: articleId,
            Country: country,
            Message: message,
            ParentCommentId: parentCommentId
        },
        success: deferred.resolve,
        error: deferred.reject
    });

    return deferred.promise();
}

// コメントを取得する
MPF.api.article.comment.getArticleComments = function (options) {
    var deferred = $.Deferred();

    if (!options.$orderby)
        options.$orderby = 'PostedDate desc';

    $.ajax({
        type: 'GET',
        url: MPF.config.api.baseUrl + 'odata/ArticleComments',
        data: options,
        success: deferred.resolve,
        error: deferred.reject
    });

    return deferred.promise();
}

// コメントを削除する
MPF.api.article.comment.deleteArticleComment = function deleteArticleComment(articleCommentId) {
    var deferred = $.Deferred();

    $.ajax({
        type: 'DELETE',
        url: MPF.config.api.baseUrl + 'odata/ArticleComments(' + articleCommentId + ')',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken },
        success: deferred.resolve,
        error: deferred.reject,
    });

    return deferred.promise();
}

//コメントにLikeしているかどうか判定する
MPF.api.article.comment.isCommentLiked = function isCommentLiked(commentId) {
    var deferred = $.Deferred();

    $.ajax({
        type: 'GET',
        url: MPF.config.api.baseUrl + 'odata/ArticleComments(' + commentId + ')/Default.IsLiked()',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken },
        success: deferred.resolve,
        error: deferred.reject
    });

    return deferred.promise();
};