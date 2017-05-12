Dropzone.autoDiscover = false;
Dropzone.options.myAwesomeDropzone = false

var dropzoneOptions = {
    autoProcessQueue: false,
    maxFiles: 1,
    acceptedFiles: 'image/*',
    maxFilesize: 10,
    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
    resize: function(file) {
        var info;
        info = {
            srcX:0,
            srcY:0,
            srcWidth: file.width,
            srcHeight: file.height,
            trgX:0,
            trgY:0,
            trgWidth: this.options.thumbnailWidth * 3,
            trgHeight: parseInt(this.options.thumbnailWidth * file.height / file.width) * 3
        }

        return info;
    },
    init: function () {
        this.on('maxfilesexceeded', function (file) {
            this.removeAllFiles();
            this.addFile(file);
        });

        this.on('addedfile', function (file) {
            var currentSection = $('#' + this.element.getAttribute('id')).parents('.main-content');
            currentSection.find('.file-caption-name').html('').append('<span class="glyphicon glyphicon-file"></span>' + file.name);
            currentSection.find('.btn-upload-photo').removeClass('hidden');
            currentSection.find('.upload-photo').removeClass('hidden');
        });

        this.on('error', function (errorMessage) {
            var currentSection = $('#' + this.element.getAttribute('id')).parents('.main-content');

            if (errorMessage.status == 'error' && errorMessage.type.match('image/*') == null) {
                currentSection.find('.post-photo-alert').addClass('alert-danger').removeClass('hidden alert-success')
                    .html('').append($('#' + this.element.getAttribute('id')).attr('data-message-not-file'));
                $('.dropzone').addClass('hidden');
            } else if (errorMessage.status == 'canceled') {
                $('.dropzone').addClass('hidden');
                currentSection.find('.file-caption-name').html('');
            }
        });
    },
    sending: function (file, xhr, formData) {
        var currentSection = $('#' + this.element.getAttribute('id')).parents('.main-content');
        var description = currentSection.find('.photo-description').val();
        formData.append('description', description);
    },
    success: function(file, response) {
        var currentSection = $('#' + this.element.getAttribute('id')).parents('.main-content');

        if (response.success) {
            currentSection.find('.post-photo-alert').addClass('alert-success').removeClass('hidden alert-danger').html('').append(response.message);
            currentSection.find('.photo-description').val('');
            currentSection.find('.articlephoto-area').html('').append(response.html);
            currentSection.find('.articlephoto-more').attr('data-current-page', response.postPhotos.current_page);

            if (response.postPhotos.current_page == response.postPhotos.last_page || response.postPhotos.last_page == 0) {
                currentSection.find('.articlephoto-more').addClass('hidden');
            } else {
                currentSection.find('.articlephoto-more').removeClass('hidden');
            }
        } else {
            var message = '';
            for (let key in response.message) {
                message += '<p>' + response.message[key] + '</p>';
            }

            currentSection.find('.post-photo-alert').addClass('alert-danger').removeClass('hidden alert-success').html('').append(message);
        }

        $('.dropzone').addClass('hidden');
        currentSection.find('.file-caption-name').html('');
        currentSection.find('.btn-upload-photo').addClass('hidden');
    },
}

var myDropzone = undefined;

function initDropzone () {
    if ($('.upload-photo').length > 0) {
        if (typeof myDropzone != 'undefined') {
            myDropzone.destroy();
        }

        myDropzone = new Dropzone('.upload-photo', dropzoneOptions);

        $('.dropzone').addClass('hidden');

        $('body').off('click', '.articlephoto-upload-btn').on('click', '.articlephoto-upload-btn', function(e) {
            e.preventDefault();
            var currentSection = $(this).parents('.main-content');

            myDropzone.processQueue();
        });

        $('body').off('click', '.btn-file').on('click', '.btn-file', function () {
            var currentSection = $(this).parents('.main-content');
            var articleId = currentSection.find('.upload-photo').attr('data-article-id');
            myDropzone.destroy();
            myDropzone = new Dropzone('#upload-photo-' + articleId, dropzoneOptions);
            currentSection.find('.post-photo-alert').addClass('hidden');
            currentSection.find('.dz-default.dz-message').click();
        });
    }

    $('body').off('click', '.get-order-photo').on('click', '.get-order-photo', function () {
        var currentSection = $(this).parents('.main-content');
        var articleId = currentSection.find('.photo-list').attr('data-article-id');

        currentSection.find('.get-order-photo').each(function () {
            $(this).removeClass('current-order');
        });

        $(this).addClass('current-order');
        let orderBy = $(this).attr('data-orderby');
        let data = {keywords: currentSection.find('.search-photo-keywords').val()};
        let url = baseUrlLocale() + 'articles/' + articleId + '/listsPhoto/' + orderBy;
        getPostPhotos(currentSection, url, data);
    });

    $('body').off('click', '.search-photo-by-user').on('click', '.search-photo-by-user', function () {
        var currentSection = $(this).parents('.main-content');
        var articleId = currentSection.find('.photo-list').attr('data-article-id');
        let orderBy = currentSection.find('.current-order').attr('data-orderby');
        let url = baseUrlLocale() + 'articles/' + articleId + '/listsPhoto/' + orderBy;
        let data = {keywords: currentSection.find('.search-photo-keywords').val()};
        getPostPhotos(currentSection, url, data);
    });

    $('body').off('keydown', '.search-photo-keywords').on('keydown', '.search-photo-keywords', function (e) {
        if (e.which == 13) {
            var currentSection = $(this).parents('.main-content');
            var articleId = currentSection.find('.photo-list').attr('data-article-id');
            let orderBy = currentSection.find('.current-order').attr('data-orderby');
            let url = baseUrlLocale() + 'articles/' + articleId + '/listsPhoto/' + orderBy;
            let data = {keywords: currentSection.find('.search-photo-keywords').val()};
            getPostPhotos(currentSection, url, data);
            return false;
        }
    });

    $('body').off('click', '.articlephoto-more').on('click', '.articlephoto-more', function () {
        var currentSection = $(this).parents('.main-content');
        var articleId = currentSection.find('.photo-list').attr('data-article-id');
        var page = parseInt($(this).attr('data-current-page')) + 1;
        let orderBy = currentSection.find('.current-order').attr('data-orderby');
        let url = baseUrlLocale() + 'articles/' + articleId + '/listsPhoto/' + orderBy;

        $.ajax({
            'url': url,
            'type': 'GET',
            'data': {
                keywords: currentSection.find('.search-photo-keywords').val(),
                page: page
            },
            success: (response) => {
                if (response.success) {
                    currentSection.find('.articlephoto-area').append(response.html);
                    currentSection.find('.articlephoto-more').attr('data-current-page', response.postPhotos.current_page);

                    if (response.postPhotos.current_page == response.postPhotos.last_page || response.postPhotos.last_page == 0) {
                        currentSection.find('.articlephoto-more').addClass('hidden');
                    } else {
                        currentSection.find('.articlephoto-more').removeClass('hidden');
                    }
                }
            }
        });
    });

    $('body').on('click', '.fileinput-remove span', function () {
        var currentSection = $(this).parents('.main-content');
        currentSection.find('.upload-photo').addClass('hidden');
        currentSection.find('.file-caption-name').html('');
        myDropzone.destroy();
    });

    $('body').off('click', '.engagement-favorite.articlephoto-like')
        .on('click', '.engagement-favorite.articlephoto-like', function () {
        var element = $(this);
        var url = element.attr('data-url');

        $.ajax({
            'url': url,
            'type': 'GET',
            success: (response) => {
                if (response.success) {
                    var favoriteCount = parseInt(element.find('.favorite-count').text());

                    if (element.hasClass('liked')) {
                        element.removeClass('liked');
                        element.find('.favorite-count').text(favoriteCount - 1);
                    } else {
                        element.addClass('liked');
                        element.find('.favorite-count').text(favoriteCount + 1);
                    }
                }
            }
        });
    });
}


function getPostPhotos(currentSection, url, data = {}) {
    currentSection.find('.articlephoto-area').html('<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>');

    $.ajax({
        'url': url,
        'type': 'GET',
        'data': data,
        success: (response) => {
            if (response.success) {
                currentSection.find('.articlephoto-area').html('').append(response.html);
                currentSection.find('.articlephoto-more').attr('data-current-page', response.postPhotos.current_page);

                if (response.postPhotos.current_page == response.postPhotos.last_page || response.postPhotos.last_page == 0) {
                    currentSection.find('.articlephoto-more').addClass('hidden');
                } else {
                    currentSection.find('.articlephoto-more').removeClass('hidden');
                }
            }
        }
    });
}

$(function () {
    initDropzone();
});
