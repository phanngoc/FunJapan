function formatRepo (repo) {
    if (repo.loading) return repo.text;

    return '<div class="clearfix">'+ encodeHTML(repo.title) + '</div>';
}

function formatRepoSelection (repo) {
    if (repo.selected) return repo.text;

    var textShow = repo.title || repo.summary;

    if (textShow) {
        textShow = encodeHTML(textShow);
    }
    return textShow;
}

$(document).ready(function () {
    $('.article-select2').on("select2:select", function(e) {
        var elementInfoArticle = $(this).parents().eq(2).children("div:first");
        elementInfoArticle.children("p:first").text(e.params.data.title);
        elementInfoArticle.children("p:nth-child(4)").text(e.params.data.summary);

        if ($(this).siblings('input').val() != e.target.value) {
            $(this).parents().eq(4).find('.update-banner-all').removeAttr('disabled');
        }

        $(this).siblings('input').val(e.target.value);
        $(this).siblings('p.text-danger').text('');
    });

    $('.article-select2').on("change", function(e) {
        if (e.currentTarget.value) {
            return;
        }

        var elementInfoArticle = $(this).parents().eq(2).children("div:first");
        $(this).parents().eq(4).find('.update-banner-all').removeAttr('disabled');
        elementInfoArticle.children("p:first").text('');
        elementInfoArticle.children("p:nth-child(4)").text('');

        $(this).siblings('input').val('');
        $(this).siblings('p.text-danger').text('');
    });

    $('.article-select2').each(processSelect2);

    function processSelect2(index) {
        var localeId = $(this).data('locale');
        var bannerId = $(this).data('banner-id');

        $(this).select2({
            placeholder: "Select a state",
            allowClear: true,
            ajax: {
                url: baseUrl() + "/admin/setting/banner/get-article",
                dataType: 'json',
                delay: 250,
                data: function data(params) {
                    return {
                        key_word: params.term,
                        locale_id: localeId,
                        page: params.page,
                        banner_id: bannerId
                    };
                },
                processResults: function processResults(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: params.page * articleSuggest < data.total
                        }
                    };
                },
                cache: true
            },

            escapeMarkup: function escapeMarkup(markup) {
                return markup;
            },
            minimumInputLength: minimumInputLength,
            minimumResultsForSearch: -1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });
    }

    $(document).on('click', '.btn-upload', function() {
        $(this).parents('.form-upload').find('.upload-file').click();
    });

    $(".upload-file").change(function(){
        var imgPreview = $(this).parents('.preview-image').find('img:first');
        var isSuccess = readURL(this, imgPreview);

        if (isSuccess) {
            $(this).siblings('input.is_uploaded_photo').val(1);
            $(imgPreview).siblings('p.text-danger').text('');
            $(this).parents().eq(4).find('.update-banner-all').removeAttr('disabled');
        } else {
            $(this).siblings('input.is_uploaded_photo').val(0);
            imgPreview.attr('src', '');
            $(this).parents().eq(4).find('.update-banner-all').removeAttr('disabled');
        }
    });

    function readURL(input, imgPreview) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var fileAcceptType = $(input).attr('accept').split(',');
            var maxSizeImage = $(input).attr('max-size');

            if (fileAcceptType.indexOf(input.files[0].type) == -1) {
                swal("Cancelled", labelWrongFileType, "error");
                input.value = '';

                return false;
            }

            if (input.files[0].size > maxSizeImage * 1024) {
                swal("Cancelled", labelMaxSize, "error");
                input.value = '';

                return false;
            }

            reader.onload = function (e) {
                imgPreview.attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

            return true;
        }
    }

    $(document).on('click', '.update-banner-all', function() {
        var element = $(this);
        var formData = new FormData(element.parent()[0]);

        $.ajax({
            url: element.parent().attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                element.attr('disabled', true);
                element.children('i:first').removeClass('hidden');
                $('.error-message').text('');
            },
            success: function (response) {
                element.children('i:first').addClass('hidden');
                element.siblings('button').removeAttr('disabled');
                swal(labelUpdateSuccess, "", "success");

                $.each(response.data, function(key, object) {
                    element.parent().children().find('input[name="banner[' + key + '][id]"]').val(object.id);
                    element.parent().children().find('input[name="banner[' + key + '][photo]"]')[0].value = '';
                    element.parent().find('#photo_error_' + key).siblings('img').attr('src', object.photo_urls.larger);
                    if (!object.photo) {
                        element.parent().children().find('input[name="banner[' + key + '][is_uploaded_photo]"]').val(0);
                    }
                });
            },
            error: function (response) {
                element.removeAttr('disabled');
                element.children('i:first').addClass('hidden');

                if (response.status == 401) {
                    swal("UNAUTHORIZED", response.responseJSON.message, "error");
                }

                if (response.status == 500) {
                    swal("UNAUTHORIZED", labelUnauthorized, "error");
                }

                var messages = response.responseJSON.message;

                $.each(messages, function(bannerId, message) {
                    var currentElement = element.parent();

                    if (message.article_locale_id) {
                        if (message.article_locale_id['duplicate']) {
                            currentElement.find('#article_locale_id_error_'+ bannerId).text(message.article_locale_id['duplicate']);
                        } else {
                            currentElement.find('#article_locale_id_error_'+ bannerId).text(message.article_locale_id[0]);
                        }

                    }

                    if (message.photo) {
                        currentElement.find('#photo_error_'+ bannerId).text(message.photo[0]);
                    }
                });

            },
        });
    });

    $(document).on('click', '.delete-banner-all', function() {
        var element = $(this);

        swal({
            title: lblConfirmRemove,
            text: lblConfirmRemoveTitle,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: lblButtonYes,
            cancelButtonText: lblButtonNo,
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: element.attr('action'),
                    type: 'DELETE',
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        element.attr('disabled', true);
                        element.children('i:first').removeClass('hidden');
                        $('.error-message').text('');
                    },
                    success: function (response) {
                        element.children('i:first').addClass('hidden');
                        swal(labelDeleteSuccess, "", "success");

                        element.siblings('div').find('img').attr('src', '');
                        element.siblings('div').find('input[type=hidden]').val(0);
                        element.siblings('div').find('input[type=file]').value = '';
                        element.siblings('div').find('.article-select2').each(function() {
                            $(this).val(null).trigger("change");
                        });
                        element.siblings('button').attr('disabled', true);
                    },
                    error: function (response) {
                        element.removeAttr('disabled');
                        element.children('i:first').addClass('hidden');

                        if (response.status == 401) {
                            swal("UNAUTHORIZED", response.responseJSON.message, "error");
                        } else if (response.status == 500) {
                            swal("UNAUTHORIZED", labelUnauthorized, "error");
                        } else {
                            swal("ERROR", response.responseJSON.message, "error");
                        }
                    },
                });
            }
        });


    });

});

