MPF.api.article.photo.getArticlePhotos = function (option) {
    var deferred = $.Deferred();

    $.ajax({
        url: MPF.config.api.baseUrl + 'odata/ArticlePhotos',
        type: 'get',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken },
        data: {
            $top: option.top,
            $skip: option.skip,
            $orderby: option.orderBy,
            $filter: 'ArticleId eq ' + option.articleId + ' and Country eq \'' + MPF.current.country + '\' and ' + option.filter,
            $expand: 'Blobs,Stats',
        },
        success: deferred.resolve,
        error: deferred.reject,
    });

    return deferred.promise();
};

MPF.api.article.photo.getArticlePhotosByAdmin = function (option) {
    var deferred = $.Deferred();

    $.ajax({
        url: MPF.config.api.baseUrl + 'odata/ArticlePhotos/Default.GetArticlePhotosByAdmin()',
        type: 'get',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken },
        data: {
            $top: option.top,
            $skip: option.skip,
            $orderby: option.orderBy,
            $filter: 'ArticleId eq ' + option.articleId + ' and Country eq \'' + MPF.current.country + '\' and ' + option.filter,
            $expand: 'Blobs,Stats',
        },
        success: deferred.resolve,
        error: deferred.reject,
    });

    return deferred.promise();
};

MPF.api.article.photo.toggleLikeArticlePhoto = function (articlePhotoId) {
    var deferred = $.Deferred();

    $.ajax({
        url: MPF.config.api.baseUrl + 'odata/ArticlePhotos(' + articlePhotoId + ')/Default.ToggleLike()',
        type: 'post',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken, 'X-MPF-Language': MPF.current.country },
        success: deferred.resolve,
        error: deferred.reject,
    });

    return deferred.promise();
};

MPF.api.article.photo.approveArticlePhoto = function (articlePhotoId) {
    var deferred = $.Deferred();

    $.ajax({
        url: MPF.config.api.baseUrl + 'odata/ArticlePhotos(' + articlePhotoId + ')/Default.Approve()',
        type: 'post',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken, 'X-MPF-Language': MPF.current.country },
        success: deferred.resolve,
        error: deferred.reject,
    });

    return deferred.promise();
};

MPF.api.article.photo.rejectArticlePhoto = function (articlePhotoId) {
    var deferred = $.Deferred();

    $.ajax({
        url: MPF.config.api.baseUrl + 'odata/ArticlePhotos(' + articlePhotoId + ')/Default.Reject()',
        type: 'post',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken },
        success: deferred.resolve,
        error: deferred.reject,
    });

    return deferred.promise();
};

MPF.api.article.photo.isLikedArticlePhoto = function (articlePhotoId) {
    var deferred = $.Deferred();

    $.ajax({
        url: MPF.config.api.baseUrl + 'odata/ArticlePhotos(' + articlePhotoId + ')/Default.IsLiked()',
        type: 'post',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken },
        success: deferred.resolve,
        error: deferred.reject,
    });

    return deferred.promise();
};

MPF.api.article.photo.addLikePointInStages = function (articlePhotoId) {
    var deferred = $.Deferred();

    $.ajax({
        url: MPF.config.api.baseUrl + 'odata/ArticlePhotos(' + articlePhotoId + ')/Default.AddLikePointInStages()',
        type: 'post',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken, 'X-MPF-Language': MPF.current.country },
        success: deferred.resolve,
        error: deferred.reject,
    });

    return deferred.promise();
};