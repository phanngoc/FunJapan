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
    var isUpdateArticle = false;

    $(document).on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        var localeId = $(e.target).data('locale-id');
        $('#locale').val(localeId).trigger('change');
    });

    $('.from-datetime-picker').datetimepicker({
        format: 'Y-m-d',
        timepicker:false,
        onShow:function( ct ){
            this.setOptions({
                maxDate : $('.to-datetime-picker').val() ? $('.to-datetime-picker').val(): false
            })
        },
    });

    $('.to-datetime-picker').datetimepicker({
        format: 'Y-m-d',
        timepicker:false,
        onShow:function( ct ){
            this.setOptions({
                minDate : $('.from-datetime-picker').val() ? $('.from-datetime-picker').val(): false
            })
        },
    });

    $('.article-select2').select2({
        placeholder: "Select a state",
        allowClear: true,
        ajax: {
            url: baseUrl() + "/admin/setting/banner/get-article",
            dataType: 'json',
            delay: 250,
            data: function data(params) {
                return {
                    key_word: params.term,
                    locale_id: $('#locale').val(),
                    page: params.page,
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

    $('.article-select2').on("select2:select", function (e) {
        isUpdateArticle = true;
    });

    $(document).on('change', '#locale', function() {
        if (isUpdateArticle) {
            swal({
                title: lblTitleChangeLocale,
                text: lblQuestionChangeLocale,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: lblButtonYes,
                cancelButtonText: lblButtonNo,
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    var localeId = $('#locale').val();

                    $('#old_locale').val(localeId);
                    $('.article-select2').select2('val', '');
                    isUpdateArticle = false;
                } else {
                    var localeId = $('#old_locale').val();

                    $('#locale').val(localeId);
                }

                $('.tab-title, .tab-pane').removeClass('active');
                $('#tab-' + localeId+ ', #tab-pane-' + localeId + '').addClass('active');
            });
        } else {
            var localeId = $('#locale').val();
            $('.tab-title, .tab-pane').removeClass('active');
            $('#tab-' + localeId+ ', #tab-pane-' + localeId + '').addClass('active');
            $('.article-select2').select2('val', '');
        }

    });

    $(document).on('click', '.btn-upload', function() {
        $(this).siblings('.upload-file').click();
    });

    $(".upload-file").change(function(){
        var imgPreview = $('#image-banner-pre');
        var isSuccess = readURL(this, imgPreview);

        if (isSuccess) {
            $(this).siblings('input.is_uploaded_photo').val(1);
            $(imgPreview).siblings('p.text-danger').text('');
        } else {
            $(this).siblings('input.is_uploaded_photo').val(0);
            imgPreview.attr('src', '');
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
                imgPreview.siblings('input[name=image_banner_base]').val(e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

            return true;
        }
    }

    $(document).on('click', '.store-banner', function() {
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
                $('#alert-message').hide();
            },
            success: function (response) {
                redrectTo(true);
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

                $.each(messages, function(field, message) {
                    $('#' + field + '_error').text(message[0]);
                });
            },
        });
    });

    $(document).on('click', '.delete-banner', function() {
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
                        redrectTo(false);
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

    function redrectTo(isUpdate) {
        var url = window.location.href.split('?')[0] + '?locale_id=' + $('#locale').val();
        if (isUpdate) {
            url += '&isSuccess=1';
        } else {
            url += '&isDeleted=1';
        }

        window.location.replace(url);
    }
});

