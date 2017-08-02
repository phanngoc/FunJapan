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

    $('.article-select2').on("select2:select", function (e) {
        isUpdateArticle = true;
    });

    $(document).on('change', '#locale', function() {
        var isEditMode = !!$('#form-edit').data('id');
        if (!isEditMode) {
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
                    $('#tab-' + localeId + ', #tab-pane-' + localeId + '').addClass('active');
                });
            } else {
                var localeId = $('#locale').val();
                $('#old_locale').val(localeId);
                $('.tab-title, .tab-pane').removeClass('active');
                $('#tab-' + localeId + ', #tab-pane-' + localeId + '').addClass('active');
                $('.article-select2').select2('val', '');
            }
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
            if (!$('#form-edit').data('id')) {
                $(this).siblings('input.is_uploaded_photo').val(0);
                imgPreview.attr('src', '');
            }
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
        var url = element.parent().attr('action');
        var bannerId = element.parent().attr('data-id');
        var hasPlace = $('#has_place_' + $('select[name=order]').val() + '_' + $('select[id=locale]').val()).val();

        if (bannerId) {
            url += '/' + bannerId;
        }

        if (hasPlace && !bannerId) {
            swal({
                title: lblTitleReplace,
                text: lblQuestionReplace,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: lblButtonYes,
                cancelButtonText: lblButtonNo,
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    update(url, formData, element);
                }
            });
        } else {
            update(url, formData, element);
        }
    });

    function update(url, formData, element) {
        $.ajax({
            url: url,
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
    }

    /*$(document).on('click', '.delete-banner', function() {
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
    });*/

    function redrectTo(isUpdate) {
        var url = window.location.href.split('?')[0] + '?locale_id=' + $('#locale').val();
        if (isUpdate) {
            url += '&isSuccess=1';
        } else {
            url += '&isDeleted=1';
        }

        window.location.replace(url);
    }

    $(document).on('click', '.btn-edit', function() {
        var element = this;

        if (isUpdateArticle) {
            swal({
                title: lblTitleChangeMode,
                text: lblQuestionChangeMode,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: lblButtonYes,
                cancelButtonText: lblButtonNo,
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    loadEditData(element);
                    isUpdateArticle = false;
                }
            });
        } else {
            loadEditData(element);
        }
    });

    function loadEditData(element) {
        $('.btn-stop-edit').removeClass('btn-stop-edit btn-warning').addClass('btn-edit btn-success').text(lblButtonEdit);
        $('.article-select2').select2('val', null);

        var articleTitle = $(element).data('article-title');
        var articleId = $(element).data('article-id');
        var from = $(element).data('from');
        var to = $(element).data('to');
        var order = $(element).data('order');
        var photo = $(element).data('photo');
        var bannerId = $(element).data('id');

        $('.article-select2').append($("<option></option>")
            .attr('value', articleId)
            .text(articleTitle));

        $('.article-select2').select2('val', articleId);
        $('#locale').attr('disabled', true);
        $('select[name=order]').val(order).attr('disabled', true);
        $('input[name=from]').val(from);
        $('input[name=to]').val(to);
        $('#image-banner-pre').attr('src', photo);
        $('.tab-title').not('.active').addClass('disabled');
        $('.tab-title a').not('.active').removeAttr('data-toggle');

        $(element).removeClass('btn-edit btn-success').addClass('btn-stop-edit btn-warning').text(lblButtonStopEdit);
        $('#form-edit').attr('data-id', bannerId);
        $(".upload-file")[0].value = '';
    }

    function resetFormAdd(element) {
        $('.article-select2').select2('val', '');
        $('#locale').removeAttr('disabled');
        $('select[name=order]').removeAttr('disabled');
        $('input[name=from]').val(null);
        $('input[name=to]').val(null);
        $('#image-banner-pre').removeAttr('src');
        $('.tab-title').not('.active').removeClass('disabled');
        $('.tab-title a').not('.active').attr('data-toggle', 'tab');

        $(element).removeClass('btn-stop-edit btn-warning').addClass('btn-edit btn-success').text(lblButtonEdit);
        $('#form-edit').removeAttr('data-id');
        $(".upload-file")[0].value = '';
        $('select[name=order]').val($('select[name=order] option:first').val());
    }

    $(document).on('click', '.btn-stop-edit', function() {
        var element = this;

        if (isUpdateArticle) {
            swal({
                title: lblTitleAddMode,
                text: lblQuestionAddMode,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: lblButtonYes,
                cancelButtonText: lblButtonNo,
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    resetFormAdd(element);
                    isUpdateArticle = false;
                }
            });
        } else {
            resetFormAdd(element);
        }
    });
});

