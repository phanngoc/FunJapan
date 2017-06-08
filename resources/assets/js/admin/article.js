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

    //datatable setting
    $.fn.dataTable.ext.errMode = 'none';

    var table = $('#article-table').DataTable({
        'order': [[ 3, "desc" ]],
        'processing': true,
        'serverSide': true,
        'searchDelay': 400,
        "language": {
            "infoFiltered": ''
        },
        'ajax': {
            'url': $('#article-table').data('url'),
            'type': 'GET',
        },
        'columns': [
            { 'data': 'id' },
            { 'data': 'title' },
            { 'data': 'user_id' },
            { 'data': 'created_at' },
            { 'data': 'published_at' },
        ],
        'columnDefs': [{
            'targets': 0,
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': 2,
            'sortable': false,
            'data': function () {
                return '';
            }
        },
        {
            'targets': 3,
            'class': 'text-center',
        },
        {
            'targets': 4,
            'class': 'text-center',
        },
        {
            'targets': 5,
            'sortable': false,
            'searchable': false,
            'data': function () {
                return '';
            }
        },
        {
            'targets': 6,
            'sortable': false,
            'searchable': false,
            'data': function () {
                return '';
            }
        },
        {
            'targets': 7,
            'sortable': false,
            'searchable': false,
            'data': function () {
                return '';
            }
        },
        {
            'targets': 8,
            'sortable': false,
            'searchable': false,
            'class': 'text-center',
            'data': function () {
                return '';
            }
        },
        {
            'targets': 9,
            'sortable': false,
            'searchable': false,
            'class': 'text-center',
            'data': function () {
                return '';
            }
        }],
        'createdRow': function (row, data, index) {
            var pageInfo = table.page.info();
            $('td', row).eq(0).empty().append(pageInfo.page * pageInfo.length + index + 1);
            var detailLink = baseUrl() + '/admin/articles/' + data.article_id + '?locale=' + data.locale_id;
            $('td', row).eq(1).empty().append('<a href="' + detailLink + '">' + encodeHTML(data.title) + '</a>');
            $('td', row).eq(2).empty().append(data.article.user.name);
            $('td', row).eq(5).empty().append(articleTypes[data.article.type]);
            $('td', row).eq(6).empty().append(data.is_top_article ? 'Yes' : 'No');
            $('td', row).eq(7).empty().append(data.hide_always ? 'Yes' : 'No');
            $('td', row).eq(8).empty().append(data.is_member_only ? 'Yes' : 'No');
            var editLink = baseUrl() + '/admin/articles/' + data.article_id + '/edit/?locale=' + data.locale_id;
            $('td', row).eq(9).empty().append('<a data-toggle="tooltip" data-placement="left" title="'
                + $('#button-edit').data('message')
                +'" href="' + editLink + '" class="edit"><i class="fa fa-pencil-square-o fa fa-lg"></i></a>'
                + '<a data-toggle="tooltip" data-placement="top" title="'
                + $('#button-delete').data('message')
                +'" href="#" class="delete"><i class="fa fa-trash-o fa fa-lg"></i></a>');
        },
        'fnDrawCallback': function (data, type, full, meta) {
            $('[data-toggle="tooltip"]').tooltip();
        },
    });

    $('.datetime-picker').datetimepicker({
        format: 'Y-m-d H:i'
    });

    addAutoApprovePhoto($('.select-type'));

    $('.select-type').on('change', function () {
        addAutoApprovePhoto($(this));
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
        url = $(this).attr('href');;
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
