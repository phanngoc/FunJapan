Dropzone.autoDiscover = false;
Dropzone.options.myAwesomeDropzone = false

var dropzoneOptions = {
    autoProcessQueue: false,
    maxFiles: 1,
    acceptedFiles: 'image/*',
    maxFilesize: 10,
    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
    init: function () {
        this.on('maxfilesexceeded', function (file) {
            this.removeAllFiles();
            this.addFile(file);
        });

        this.on('addedfile', function (file) {
            var currentSection = $('#' + this.element.getAttribute('id')).parents('.main-content');
            currentSection.find('.file-caption-name').html('').append('<span class="glyphicon glyphicon-file"></span>' + file.name);
            currentSection.find('.btn-upload-photo').removeClass('hidden');
        })
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
            currentSection.find('.articlephoto-area').prepend(response.html);
        } else {
            var message = '';
            for (let key in response.message) {
                message += '<p>' + response.message[key] + '</p>';
            }

            currentSection.find('.post-photo-alert').addClass('alert-danger').removeClass('hidden alert-success').html('').append(message);
        }

        $('.upload-photo').css('display', 'none');
        currentSection.find('.file-caption-name').html('');
        currentSection.find('.btn-upload-photo').addClass('hidden');
    },
}

$(function () {
    var myDropzone = new Dropzone('.upload-photo', dropzoneOptions);
    $('.dropzone').css('display', 'none');

    $('body').on('click', '.articlephoto-upload-btn', function(e) {
        e.preventDefault();
        var currentSection = $(this).parents('.main-content');

        if (currentSection.find('.photo-description').val() != '') {
            myDropzone.processQueue();
        } else {
            currentSection.find('.post-photo-alert').addClass('alert-danger').removeClass('hidden alert-success')
                .html('').append($('.btn-upload-photo').attr('alert-description'));
        }
    });

    $('body').on('click', '.btn-file', function () {
        var currentSection = $(this).parents('.main-content');
        var articleId = currentSection.find('.upload-photo').attr('data-article-id');
        myDropzone.destroy();
        myDropzone = new Dropzone('#upload-photo-' + articleId, dropzoneOptions);
        currentSection.find('.post-photo-alert').addClass('hidden');
        $('.dropzone').css('display', 'block');
        currentSection.find('.dz-default.dz-message').click();
    });

    $('body').on('click', '.get-order-photo', function () {
        var currentSection = $(this).parents('.main-content');
        var articleId = currentSection.find('.upload-photo').attr('data-article-id');

        currentSection.find('.get-order-photo').each(function () {
            $(this).removeClass('current-order');
        });

        $(this).addClass('current-order');
        let orderBy = $(this).attr('data-orderby');
        let data = {keywords: currentSection.find('.search-photo-keywords').val()};
        let url = '/articles/' + articleId + '/listsPhoto/' + orderBy;
        getPostPhotos(currentSection, url, data);
    });

    $('body').on('click', '.search-photo-by-user', function () {
        var currentSection = $(this).parents('.main-content');
        var articleId = currentSection.find('.upload-photo').attr('data-article-id');
        let orderBy = currentSection.find('.current-order').attr('data-orderby');
        let url = '/articles/' + articleId + '/listsPhoto/' + orderBy;
        let data = {keywords: currentSection.find('.search-photo-keywords').val()};
        getPostPhotos(currentSection, url, data);
    });

    $('body').on('keydown', '.search-photo-keywords', function (e) {
        if (e.which == 13) {
            var currentSection = $(this).parents('.main-content');
            var articleId = currentSection.find('.upload-photo').attr('data-article-id');
            let orderBy = currentSection.find('.current-order').attr('data-orderby');
            let url = '/articles/' + articleId + '/listsPhoto/' + orderBy;
            let data = {keywords: currentSection.find('.search-photo-keywords').val()};
            getPostPhotos(currentSection, url, data);
            return false;
        }
    });

    $('body').on('click', '.articlephoto-more', function () {
        var currentSection = $(this).parents('.main-content');
        var articleId = currentSection.find('.upload-photo').attr('data-article-id');
        var page = parseInt($(this).attr('data-current-page')) + 1;
        let orderBy = currentSection.find('.current-order').attr('data-orderby');
        let url = '/articles/' + articleId + '/listsPhoto/' + orderBy;

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
});

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
