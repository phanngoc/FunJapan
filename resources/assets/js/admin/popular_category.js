$(document).ready(function (e) {
    var url = $('#suggest-url').data('url') + '/?locale_id=' + $('#locale').val();
    settingSelect2(url);
    $('#locale').on('change', function (e) {
        var url = $('#suggest-url').data('url') + '/?locale_id=' + $('#locale').val();
        $('#link').empty();
        settingSelect2(url);
    });

    var table = $('#series-table').DataTable({
        'order': [[ 4, "desc" ]],
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
            { 'data': 'name' },
            { 'data': 'photo' },
            { 'data': 'link' },
            { 'data': 'created_at' },
        ],
        'columnDefs': [{
            'targets': 0,
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': 2,
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': 4,
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': 5,
            'sortable': false,
            'class': 'text-center',
            'data': function () {
                return '';
            }
        }],
        'createdRow': function (row, data, index) {
            var pageInfo = table.page.info();
            $('td', row).eq(0).empty().append(pageInfo.page * pageInfo.length + index + 1);
            $('td', row).eq(2).empty().append('<img src="' + data.photo_urls.small + '">');
            $('td', row).eq(3).empty().append(data.name_link);
            editLink = baseUrl() + '/admin/popular-category/edit/' + data.id;
            $('td', row).eq(5).empty().append('<a data-toggle="tooltip" data-placement="left" title="'
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
function template(data, container)
{
    return encodeHTML(data.text) || encodeHTML(data.name);
}

function settingSelect2(url)
{
    $("#link").select2({
        ajax: {
            url: url,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.items,
                pagination: {
                    more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 3,
        templateResult: function (data) {
            console.log(data.name);
            if (data.loading) return data.text;

            return data.text || encodeHTML(data.name);
        },
        templateSelection: template,
    });
}

function readUrl (input) {
    var oldSrc = $('#preview-img').data('url');
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview-section').removeClass('hidden');
            $('#preview-img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        if (oldSrc == '') {
            $('#preview-section').addClass('hidden');
        } else {
            $('#preview-img').attr('src', oldSrc);
        }
    }
}
