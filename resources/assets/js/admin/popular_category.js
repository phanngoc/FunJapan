$(document).ready(function (e) {
    // var url = $('#suggest-url').data('url') + '/?locale_id=' + $('#locale').val();
    // settingSelect2(url);
    $('#locale').on('change', function (e) {
        var locale = $(this).val();
        $('#link').empty();
        $.each(allCategories[locale], function(index, val) {
            $('#link').append('<option value="' + val.id + '">' + encodeHTML(val.name) + '</option>')
        });
    });

    var table = $('#series-table').DataTable({
        'order': [[ 3, "desc" ]],
        'processing': true,
        'serverSide': true,
        'searchDelay': 400,
        "language": {
            "infoFiltered": ''
        },
        'ajax': {
            'url': $('#series-table').data('url'),
            'type': 'GET',
        },
        'columns': [
            { 'data': 'id' },
            { 'data': 'photo' },
            { 'data': 'name' },
            { 'data': 'created_at' },
        ],
        'columnDefs': [{
            'targets': 0,
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': 1,
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': 2,
            'sortable': true,
        },
        {
            'targets': 3,
            'sortable': true,
            'class': 'text-center',
        },
        {
            'targets': 4,
            'sortable': false,
            'class': 'text-center',
            'data': function () {
                return '';
            }
        }],
        'createdRow': function (row, data, index) {
            var pageInfo = table.page.info();
            $('td', row).eq(0).empty().append(pageInfo.page * pageInfo.length + index + 1);
            $('td', row).eq(1).empty().append('<img src="' + data.photo_urls.small + '">');
            $('td', row).eq(2).empty().append(encodeHTML(data.name));
            editLink = baseUrl() + '/admin/popular-category/edit/' + data.id;
            $('td', row).eq(4).empty().append('<a data-toggle="tooltip" data-placement="left" title="'
                + $('#button-edit').data('message')
                +'" href="'
                + editLink
                + '" class="edit"><i class="fa fa-pencil-square-o fa fa-lg"></i></a>'
                + '<a data-toggle="tooltip" data-placement="top" title="'
                + $('#button-delete').data('message')
                +'" href="#" class="delete"><i data-id="'
                + data.id
                + '" class="fa fa-trash fa fa-lg"></i></a>');
        },
        'fnDrawCallback': function (data, type, full, meta) {
            $('[data-toggle="tooltip"]').tooltip();
        },
    });
    $('.select-locale').on('change', function () {
        $('.category-list').submit();
    });
    $('#photo').on('change', function () {
        readUrl(this);
    });

    $(document).on('click', '.delete', function (e) {
        deleteAction = baseUrl() + '/admin/popular-category/delete/' + $(e.target).data('id');
        swal({
            title: $('#delete-confirm').data('message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            $('#deleteForm').attr('action', deleteAction).submit();
        });
    });
});

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
