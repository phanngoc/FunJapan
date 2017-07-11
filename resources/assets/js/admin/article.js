$(document).ready(function () {
    $('.article-content').markdown({
        autofocus:false,
        savable:false
    });
    $('#locale').change(function() {
        getCategory();
    });

    function getCategory() {
        var id = $('#locale').val();
        var placeHolderCategory = $('#infor').data('place-holder');
        var urlAjax = $('#infor').data('url-ajax');
        $.ajax({
            type: 'GET',
            url: urlAjax,
            data: {'locale_id':id},
            success: function (response) {
                $("#category").html("");
                $("#category").append('<option selected="selected" disabled="disabled" hidden="hidden" value="">'+ placeHolderCategory +'</option>');
                $.each(response, function(key, value) {
                      $("#category").append('<option value="'+key+'">'+encodeHTML(value)+'</option>');
                });
            },
            error: function (e) {
            }
        });
    }

    $('.article-tag').tagsinput({
        cancelConfirmKeysOnEmpty: false,
        typeahead: {
            source: function(query) {
                return $.get($('.article-tag').data('url') + '/?query='+ query);
            },
            afterSelect: function(val) { this.$element.val(""); },
            items: 5,
            autoSelect: false,
        },
        freeInput: true,
        trimValue: true,
    });

    $('.bootstrap-tagsinput input').on('keypress', function(e) {
        if (e.keyCode == 13) {
            e.keyCode = 188;
            e.preventDefault();
        };
    });

    $('.datetime-picker').datetimepicker({
        format: 'Y-m-d H:i'
    });

    addAutoApprovePhoto($('.select-type'));

    $('.select-type').on('change', function () {
        addAutoApprovePhoto($(this));
    });

    $('.date-filter').datepicker({
        minViewMode: 1,
        format: 'yyyy MM',
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        todayHighlight: true
    });

    $('.select-locale').on('change', function (e) {
        $('.articles-list').submit();
    });

    $('#thumbnail').on('change', function (e) {
        readUrl(this);
    });

    $('.cancel').on('click', function(e) {
        e.preventDefault();
        var message = $(this).data('message');
        url = $(this).attr('href');
        swal({
            title: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            location.href = url;
        });
    });

    $('.dropdown-menu.search-by').on('click', 'a', function () {
        $('[name="searchColumn"]').val($(this).attr('data-column'));
        $('.selected-search-by').empty().text($(this).text());
    });

    $('body').on('click', '.stop-btn', function () {
        var element = $(this);
        var articleId = element.attr('data-article-id');
        var url = element.attr('data-url');
        swal({
            title: element.attr('data-message-confirm') + element.attr('data-title'),
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: element.attr('data-yes-confirm'),
            cancelButtonText: element.attr('data-cancel-confirm'),
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        'articleId': articleId
                    },
                    success: (response) => {
                        if (response.success) {
                            swal(response.message, '', 'success');
                            element.attr('disabled', true);
                            element.parents('tr').find('td.label-locale span.label').each(function () {
                                if ($(this).hasClass('label-custom-published') || $(this).hasClass('label-custom-schedule')) {
                                    $(this).removeClass().addClass('label label-custom-stop');
                                }
                            });
                        } else {
                            swal(response.message, '', 'error');
                        }

                    },
                    error: function (e) {
                    }
                });
            }
        });
    });

    $('body').on('click', '.date-filter-btn', function () {
        $('input[name="dateFilter"]').val($('.date-filter').val());
        $('form.filter-sort-form').submit();
    });
});

function addAutoApprovePhoto (element) {
    var typePhoto = $('#infor').data('type-photo');
    var typeCampaign = $('#infor').data('type-campaign');
    var typeCoupon = $('#infor').data('type-coupon');
    if (typeof typePhoto != 'undefined') {
        if (element.val() == typePhoto) {
            $('.auto-approve-photo').removeClass('hidden');
            $('.date-time-campaign').removeClass('hidden');
        } else if (element.val() == typeCampaign || element.val() == typeCoupon) {
            $('.auto-approve-photo').addClass('hidden');
            $('.date-time-campaign').removeClass('hidden');
        } else {
            $('.auto-approve-photo').addClass('hidden');
            $('.date-time-campaign').addClass('hidden');
        }
    }
}

function readUrl (input) {
    var oldSrc = $('#preview-img').data('url');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var ext = input.value.split('.').pop().toLowerCase();
        var mimes = $('#extension').data('extension').split(",");
        var maxSize = $('#size').data('size');
        var mess = $('#mimes-message').data('message');
        var messSize = $('#size-message').data('message');
        if ($.inArray(ext, mimes) == -1) {
            input.value = '';
            swal("Cancelled", mess, "error");
            if (oldSrc == '') {
                $('#preview-section').addClass('hidden');
            } else {
                $('#preview-img').attr('src', oldSrc);
            }
        } else {
            var size = (input.files[0].size);
            if ((size/1024) > maxSize) {
                input.value = '';
                swal("Cancelled", messSize, "error");
                if (oldSrc == '') {
                    $('#preview-section').addClass('hidden');
                } else {
                    $('#preview-img').attr('src', oldSrc);
                }
            } else {
                reader.onload = function (e) {
                    $('#preview-section').removeClass('hidden');
                    $('#preview-img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    } else {
        if (oldSrc == '') {
            $('#preview-section').addClass('hidden');
        } else {
            $('#preview-img').attr('src', oldSrc);
        }
    }
}
