$(function () {
    if (typeof mpfArticlePhoto_isManageArticlePhoto === "undefined") {
        return;
    }

    var skip = 0;
    var orderBy = $(".articlephoto-order a.current-order").data("orderby");
    var filter = "true";
    var userFilter = "";

    if (mpfArticlePhoto_isManageArticlePhoto) {
        filter = $(".articlephoto-filter a").data("filter");
        mpfArticlePhoto_articleId = $(".articlephoto-select-article option:selected").prop('value');
    }

    var messageLengthForDesktop = 50;
    var messageLengthForManagement = 30;
    var messageLengthForMobile = 30;

    var getUserFilter = function () {
        var userFilter = "";
        var name = $.trim($(".articlephoto-search input").val());
        if (name != "") {
            userFilter = " and contains(Author/DisplayName,'" + name + "')";
        }

        return userFilter;
    };

    MPF.articlePhoto = {
        approvedName: "Approved",
        rejectedName: "Rejected",
        pendingName: "Pending",
        approvedClass: "alert-success",
        rejectedClass: "alert-danger",
        pendingClass: "alert-info",
        getLikeHtml: function (count) {
            return '<i class="fa fa-heart"></i><span><b>' + ("    " + count).substr(-4).replace(/ /g, "&nbsp;") + '</b></span>';
        },
        getMessageMaxLength: function () {
            var length = messageLengthForMobile;
            if (MPF.current.device.isDesktop) {
                length = messageLengthForDesktop;
                if (mpfArticlePhoto_isManageArticlePhoto) {
                    length = messageLengthForManagement;
                }
            }

            return length;
        },
        getStatusName: function (isApproved) {
            switch (isApproved) {
                case true:
                    return MPF.articlePhoto.approvedName;
                case false:
                    return MPF.articlePhoto.rejectedName;
                default:
                    return MPF.articlePhoto.pendingName;
            }
        },
        getStatusClass: function (isApproved) {
            switch (isApproved) {
                case true:
                    return MPF.articlePhoto.approvedClass;
                case false:
                    return MPF.articlePhoto.rejectedClass;
                default:
                    return MPF.articlePhoto.pendingClass;
            }
        },
        approve: function (articlePhotoId) {
            if (!MPF.current.user.isAuthenticated) {
                var queryString = $.param($.extend({}, { itemid: MPF.current.itemId }));
                location.href = queryString ? MPF.config.loginUrl + '?' + queryString : MPF.config.loginUrl;

                return;
            }

            MPF.api.article.photo.approveArticlePhoto(articlePhotoId)
            .done(function () {
                $(".articlephoto-status[data-articlephoto-id^='" + articlePhotoId + "']")
                    .removeClass(MPF.articlePhoto.pendingClass + " " + MPF.articlePhoto.rejectedClass)
                    .addClass(MPF.articlePhoto.approvedClass)
                    .html('<strong>' + MPF.articlePhoto.approvedName + '</strong><div class="form-group checkbox"><input type="checkbox" name="articlephoto-check" value="' + articlePhotoId + '" /></div>');
            });
        },

        reject: function (articlePhotoId) {
            if (!MPF.current.user.isAuthenticated) {
                var queryString = $.param($.extend({}, { itemid: MPF.current.itemId }));
                location.href = queryString ? MPF.config.loginUrl + '?' + queryString : MPF.config.loginUrl;

                return;
            }

            MPF.api.article.photo.rejectArticlePhoto(articlePhotoId)
            .done(function () {
                $(".articlephoto-status[data-articlephoto-id^='" + articlePhotoId + "']")
                    .removeClass(MPF.articlePhoto.pendingClass + " " + MPF.articlePhoto.approvedClass)
                    .addClass(MPF.articlePhoto.rejectedClass)
                    .html('<strong>' + MPF.articlePhoto.rejectedName + '</strong><div class="form-group checkbox"><input type="checkbox" name="articlephoto-check" value="' + articlePhotoId + '" /></div>');
            });
        },
    };

    // initial load
    loadArticlePhotos(0, orderBy, filter, userFilter);
    skip += mpfArticlePhoto_requestCount;

    // more
    $(".articlephoto-more").click(function () {
        $(this).addClass("hidden");
        loadArticlePhotos(skip, orderBy, filter, userFilter);
        skip += mpfArticlePhoto_requestCount;
    });

    // sort order
    $(".articlephoto-order a").click(function () {
        if ($(this).hasClass("disabled")) {
            return false;
        }

        $(this).addClass("disabled");

        orderBy = $(this).data("orderby");
        userFilter = getUserFilter();
        loadArticlePhotos(0, orderBy, filter, userFilter);
        skip = mpfArticlePhoto_requestCount;
        $(".articlephoto-order a").removeClass("current-order");
        $(this).addClass("current-order");

        $(this).removeClass("disabled");
    });

    // filter
    $(".articlephoto-filter a").click(function () {
        if ($(this).hasClass("disabled")) {
            return false;
        }

        $(this).addClass("disabled");

        filter = $(this).data("filter");
        userFilter = getUserFilter();
        loadArticlePhotos(0, orderBy, filter, userFilter);
        skip = mpfArticlePhoto_requestCount;
        $(".articlephoto-filter a").removeClass("current-filter");
        $(this).addClass("current-filter");

        $(this).removeClass("disabled");
    });

    // check all
    $('.articlephoto-check-all').change(function () {
        $('input[name=articlephoto-check]').prop('checked', this.checked);
    });

    // hidden upload button
    $(".articlephoto-upload .file").change(function () {
        if ($(this).val() && !$(".file-input.has-error").length) {
            $(".articlephoto-upload-btn").removeClass("hidden");
        } else {
            $(".articlephoto-upload-btn").addClass("hidden");
        }
    });

    // select article drop down
    $(".articlephoto-select-article").change(function () {
        mpfArticlePhoto_articleId = $(".articlephoto-select-article option:selected").prop('value');
        userFilter = getUserFilter();
        loadArticlePhotos(0, orderBy, filter, userFilter);
        skip = mpfArticlePhoto_requestCount;
    });

    // approve multiple
    $(".articlephoto-approve-checked").click(function () {
        $('input[name=articlephoto-check]').each(function () {
            if ($(this).prop('checked')) {
                var articlePhotoId = $(this).prop('value');
                MPF.articlePhoto.approve(articlePhotoId);
            }
        });
    });

    // reject multiple
    $(".articlephoto-reject-checked").click(function () {
        $('input[name=articlephoto-check]').each(function () {
            if ($(this).prop('checked')) {
                var articlePhotoId = $(this).prop('value');
                MPF.articlePhoto.reject(articlePhotoId);
            }
        });
    });

    // search by user
    $(".articlephoto-search .btn").click(function () {
        userFilter = getUserFilter();
        loadArticlePhotos(0, orderBy, filter, userFilter);
        skip = mpfArticlePhoto_requestCount;
    });
    $(".articlephoto-search input").keyup(function (e) {
        if (e.which == 13) {
            $(".articlephoto-search .btn").click();
        }
    });
    $(".articlephoto-search-minimize .btn").click(function () {
        $(".articlephoto-search").removeClass("hidden-xs");
        $(this).addClass("hidden");
    });

    // resize image
    $(window).resize(function () {
        $(".articlephoto-image").height($(".articlephoto").width());
    });
})

function loadArticlePhotos(skip, orderBy, filter, userFilter) {
    var option = {
        articleId: mpfArticlePhoto_articleId,
        skip: skip,
        top: mpfArticlePhoto_requestCount,
        orderBy: orderBy,
        filter: filter + userFilter,
    };

    if (skip == 0) {
        $(".articlephoto-area").empty();
        var existsArticlePhotos = null;
    } else {
        // more
        var existsArticlePhotos = [];
        $(".articlephoto").each(function () {
            existsArticlePhotos.push($(this).data("articlephotoId"));
        });
    }

    $(".articlephoto-area").append('<p class="articlephoto-loading text-center">Now Loading...</p>');

    if (mpfArticlePhoto_isManageArticlePhoto) {
        MPF.api.article.photo.getArticlePhotosByAdmin(option)
        .done(function (articlephotos) {
            $(".articlephoto-loading").remove();
            buildArticlePhotos(articlephotos, existsArticlePhotos);
        });
    } else {
        MPF.api.article.photo.getArticlePhotos(option)
        .done(function (articlephotos) {
            $(".articlephoto-loading").remove();
            buildArticlePhotos(articlephotos, existsArticlePhotos);
        });
    }
}

function buildArticlePhotos(articlephotos, existsArticlePhotos) {
    if (mpfArticlePhoto_requestCount <= articlephotos.value.length) {
        $(".articlephoto-more").removeClass("hidden");
    } else {
        $(".articlephoto-more").addClass("hidden");
    }

    $.each(articlephotos.value, function (index, articlephoto) {
        var message = articlephoto.Message;
        if (articlephoto.Message.replace(/\n/g, "").length > MPF.articlePhoto.getMessageMaxLength()) {
            message = articlephoto.Message.replace(/\n/g, "").substr(0, MPF.articlePhoto.getMessageMaxLength()) + "...";
        }

        // emptyだと何故か縦サイズが増えるため、empty時はスペースを入れる
        if (message == null || message == "") {
            message = "&nbsp;";
        }

        var srcDate = new Date(articlephoto.PostedDate);
        var postedDate = srcDate.getFullYear() + "-" + ("0" + (srcDate.getMonth() + 1)).substr(-2) + "-" + ("0" + srcDate.getDate()).substr(-2) + " " + ("0" + srcDate.getHours()).substr(-2) + ":" + ("0" + srcDate.getMinutes()).substr(-2);

        // skip already exists 
        if (existsArticlePhotos != null && ($.inArray(articlephoto.Id, existsArticlePhotos) >= 0)) {
            return;
        }

        if (!mpfArticlePhoto_isManageArticlePhoto) {
            // Article
            if (MPF.current.device.isDesktop) {
                var columnClass = "col-xs-4";
            } else {
                var columnClass = "col-xs-6 col-sm-4 col-md-3 col-lg-2";
            }

            var dom = '<div class="articlephoto ' + columnClass + ' text-center" data-articlephoto-id="' + articlephoto.Id + '">' +
                '<div class="articlephoto-image">' +
                    '<a class="image-popup-vertical-fit" href="' + articlephoto.Blobs[0].PhotoUrl + '" title="' + articlephoto.Message + '">' +
                        '<img class="img-thumbnail" src="' + articlephoto.Blobs[0].ThumbnailUrl + '" />' +
                    '</a>' +
                '</div>' +
                '<div>' +
                    '<div class="text-left articlephoto-meta">' +
                        '<span class="datetime">' + postedDate + '</span>' +
                        '<a href="javascript:void(0)" class="engagement-favorite articlephoto-like" data-articlephoto-id="' + articlephoto.Id + '" >' +
                            MPF.articlePhoto.getLikeHtml(articlephoto.Stats.LikeCount) +
                        '</a>' +
                    '</div>' +
                    '<strong><p class="articlephoto-postedby" data-articlephoto-id="' + articlephoto.Id + '">&nbsp;</p></strong>' +
                    '<div class="articlephoto-message">' +
                        '<p class="text-left">' + message + '</p>' +
                    '</div>' +
                '</div>' +
            '</div>';
        } else {
            // Management
            if (MPF.current.device.isDesktop) {
                var columnClass = "col-xs-3";
            } else {
                var columnClass = "col-xs-6 col-sm-4 col-md-3 col-lg-2";
            }
            var dom = '<div class="articlephoto ' + columnClass + ' text-center" data-articlephoto-id="' + articlephoto.Id + '">' +
                '<div class="articlephoto-status alert ' + MPF.articlePhoto.getStatusClass(articlephoto.IsApproved) + '" data-articlephoto-id="' + articlephoto.Id + '">' +
                    '<strong>' + MPF.articlePhoto.getStatusName(articlephoto.IsApproved) + '</strong>' +
                    '<div class="form-group checkbox">' +
                        '<input type="checkbox" name="articlephoto-check" value="' + articlephoto.Id + '"/>' +
                    '</div>' +
                '</div>' +
                '<div class="articlephoto-image">' +
                    '<a class="image-popup-vertical-fit" href="' + articlephoto.Blobs[0].PhotoUrl + '" title="' + articlephoto.Message + '">' +
                        '<img class="img-thumbnail" src="' + articlephoto.Blobs[0].ThumbnailUrl + '"/>' +
                    '</a>' +
                '</div>' +
                '<div class="text-left">' +
                    '<div class="articlephoto-approves">' +
                        '<a class="articlephoto-approve" data-articlephoto-id="' + articlephoto.Id + '" href="javascript:void(0);" ><i class="fa fa-thumbs-o-up"></i> Approve</a>' +
                    '</div>' +
                    '<div>' +
                        '<a class="articlephoto-reject" data-articlephoto-id="' + articlephoto.Id + '" href="javascript:void(0);" ><i class="fa fa-thumbs-o-down"></i> Reject</a>' +
                    '</div>' +
                '</div>' +
                '<div>' +
                    '<div class="text-left articlephoto-meta">' +
                        '<span class="datetime">' + postedDate + '</span>' +
                        '<a href="javascript:void(0)" class="engagement-favorite articlephoto-like" data-articlephoto-id="' + articlephoto.Id + '">' +
                            MPF.articlePhoto.getLikeHtml(articlephoto.Stats.LikeCount) +
                        '</a>' +
                    '</div>' +
                    '<strong><p class="articlephoto-postedby" data-articlephoto-id="' + articlephoto.Id + '"></p>&nbsp;</strong>' +
                    '<div class="articlephoto-message-mng">' +
                        '<p class="text-left">' + message + '</p>' +
                    '</div>' +
                '</div>' +
            '</div>';
        }

        // append dom
        $(".articlephoto-area").append(dom);
        $(".articlephoto-image").height($(".articlephoto").width());

        // set user name
        MPF.getPublicUserProfile(articlephoto.PostedBy)
        .done(function (profile) {
            $(".articlephoto-postedby[data-articlephoto-id^='" + articlephoto.Id + "']").text(profile.DisplayName.split(' ')[0].substr(0,15));
        })
        .fail(function (jqXHR) {
            if (jqXHR.status == 404) {
                $(".articlephoto-postedby[data-articlephoto-id^='" + articlephoto.Id + "']").text("(Someone)");
            }
        });
    });

    // like
    $(".articlephoto-like").unbind('click');
    $(".articlephoto-like").click(function () {
        if ($(this).hasClass("disabled")) {
            return false;
        }

        $(this).addClass("disabled");

        var link = $(this);
        var articlePhotoId = link.data("articlephotoId");
        if (!MPF.current.user.isAuthenticated) {
            var queryString = $.param($.extend({}, { itemid: MPF.current.itemId }));
            location.href = queryString ? MPF.config.loginUrl + '?' + queryString : MPF.config.loginUrl;

            return;
        }

        var count = parseInt(link.text());
        if (link.hasClass("liked")) {
            link.html(MPF.articlePhoto.getLikeHtml(count - 1));
            link.removeClass("liked");
        } else {
            link.html(MPF.articlePhoto.getLikeHtml(count + 1));
            link.addClass("liked");
        }

        MPF.api.article.photo.toggleLikeArticlePhoto(articlePhotoId)
        .done(function () {
            MPF.api.article.photo.addLikePointInStages(articlePhotoId)
            .done(function (gaugeStage) {
                if (gaugeStage.Stage != null) {
                    $(".articlephoto-dialog .modal-body").html('<p><b>You\'ve got <b style="color:red;">' + gaugeStage.Gauge + '</b> FP !</b></p><p>You\'ve achived <b style="color:red;">' + gaugeStage.Stage + '</b> favorites. </p>');
                    $(".articlephoto-dialog").modal("show");

                    // change display fp
                    var fp = parseInt($(".funjapan-points").text().replace(/[^0-9]/g, ''));
                    $(".funjapan-points").text(String(fp + gaugeStage.Gauge).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,') + " FP");
                }
            });
        });

        $(this).removeClass("disabled");
    });

    $(".articlephoto-like").each(function () {
        if (!MPF.current.user.isAuthenticated) {
            return;
        }

        var link = $(this);
        var articlePhotoId = link.data("articlephotoId");
        MPF.api.article.photo.isLikedArticlePhoto(articlePhotoId)
        .done(function (isLiked) {
            var count = parseInt(link.text());
            if (isLiked.value) {
                link.html(MPF.articlePhoto.getLikeHtml(count));
                link.addClass("liked");
            } else {
                link.html(MPF.articlePhoto.getLikeHtml(count));
                link.removeClass("liked");
            }
        });
    });

    // single approve / reject
    $(".articlephoto-approve").unbind('click');
    $(".articlephoto-approve").click(function () {
        var articlePhotoId = $(this).data("articlephotoId");
        MPF.articlePhoto.approve(articlePhotoId);
    });
    $(".articlephoto-reject").unbind('click');
    $(".articlephoto-reject").click(function () {
        var articlePhotoId = $(this).data("articlephotoId");
        MPF.articlePhoto.reject(articlePhotoId);
    });

    // no results
    if ($(".articlephoto").length == 0) {
        $(".articlephoto-area").append("<p>There are no posts.</p>");
    }

    // initialize magnificPopup 
    $('.image-popup-vertical-fit').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-img-mobile',
        image: {
            verticalFit: true
        }
    });
}