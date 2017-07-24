$(document).ready(function () {
    $('.from-datetime-picker').each(processStartDate);

    function processStartDate(index) {
        var localeId = $(this).data('locale');
        commonHandleStartDate(this, 'max-date-locale-' + localeId);
    }

    function commonHandleStartDate(element, idMaxInput) {
        $(element).datetimepicker({
            format: 'Y-m-d',
            scrollMonth : false,
            scrollInput : false,
            timepicker:false,
            onShow:function(ct){
                this.setOptions({
                    maxDate : $('#' + idMaxInput + '').val() ? $('#' + idMaxInput + '').val(): false
                })
            },
        });
    }

    $('.to-datetime-picker').each(processEndDate);

    function processEndDate(index) {
        var localeId = $(this).data('locale');

        commonHandleEndDate(this, 'min-date-locale-' + localeId);
    }

    function commonHandleEndDate(element, idMinInput) {
        $(element).datetimepicker({
            format: 'Y-m-d',
            timepicker:false,
            scrollMonth : false,
            scrollInput : false,
            onShow:function(ct){
                this.setOptions({
                    minDate : $('#' + idMinInput + '').val() ? $('#' + idMinInput + '').val(): false
                })
            },
        });
    }

    $('.from-datetime-picker-edit').each(processStartDateEdit);

    $('.to-datetime-picker-edit').each(processEndDateEdit);

    function processStartDateEdit(index) {
        var localeId = $(this).data('locale');
        commonHandleStartDate(this, 'max-date-edit-locale-' + localeId);
    }

    function processEndDateEdit(index) {
        var localeId = $(this).data('locale');

        commonHandleEndDate(this, 'min-date-edit-locale-' + localeId);
    }

    $(document).on('click', '.btn-upload', function() {
        var localeId = $(this).data('locale');

        $('#upload-file-' + localeId + '').click();
    });

    $(".upload-file").change(function(){
        var localeId = $(this).data('locale');
        var imgPreview = $('#image-advertisement-' + localeId + '');
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

    $(document).on('click', '.btn-public', function() {
        var element = $(this);
        var formData = new FormData(element.parents().eq(3)[0]);

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
                element.removeAttr('disabled');
                window.location.reload(true);
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

                $.each(messages, function(localeId, message) {
                    if (message.end_date) {
                        $('#to_error_' + localeId + '').text(message.end_date);
                    }

                    if (message.start_date) {
                        $('#from_error_' + localeId + '').text(message.start_date);
                    }

                    if (message.url) {
                        $('#url_error_' + localeId + '').text(message.url);
                    }

                    if (message.photo) {
                        $('#photo_error_' + localeId + '').text(message.photo);
                    }
                });

            },
        });
    });

    $(document).on('click', '.btn-edit', function() {
        var element = $(this);
        var localeId = $(this).data('locale');
        var url = $(this).data('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'start_date' : $('#min-date-edit-locale-' + localeId + '').val(),
                'end_date' : $('#max-date-edit-locale-' + localeId + '').val(),
                'is_active' : $('#is_active_' + localeId + '').val(),
            },
            beforeSend: function () {
                element.attr('disabled', true);
                element.children('i:first').removeClass('hidden');
                $('.error-message').text('');
            },
            success: function (response) {
                element.removeAttr('disabled');
                window.location.reload();
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

                var message = response.responseJSON.message;

                if (message.end_date) {
                    $('#to_edit_error_' + localeId + '').text(message.end_date);
                }

                if (message.start_date) {
                    $('#from_edit_error_' + localeId + '').text(message.start_date);
                }
            },
        });
    });

    $('.input-url').change(function(){
        var isCanNotUpdate = true;

        $('.input-url').each(function(index) {
            var value = $(this).val();

            if (value) {
                isCanNotUpdate = false;

                return false;
            }
        });

        if (isCanNotUpdate) {
            $('.btn-public').attr('disabled', true);
        } else {
            $('.btn-public').removeAttr('disabled');
        }
    });
});

