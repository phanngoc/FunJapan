$(document).ready(function () {
    var table = $('#tag-table').DataTable({
        'order': [[ 2, "desc" ]],
        'processing': true,
        'serverSide': true,
        'searchDelay': 400,
        "language": {
            "infoFiltered": ''
        },
        'ajax': {
            'url': $('#tag-table').data('url'),
            'type': 'GET',
        },
        'columns': [
            { 'data': 'id' },
            { 'data': 'name' },
            { 'data': 'created_at' },
        ],
        'columnDefs': [
        {
            'targets': 0,
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': 2,
            'class': 'text-center',
        },
        {
            'targets': 3,
            'sortable': false,
            'class': 'text-center',
            'data': function () {
                return '';
            }
        }],
        'createdRow': function (row, data, index) {
            var pageInfo = table.page.info();
            $('td', row).eq(0).empty().append(pageInfo.page * pageInfo.length + index + 1);
            if (typeof data.hot_tags == 'undefined') {
                $('td', row).eq(3).empty().append('<a href="#" class="remove-hot-tag" data-tag-id="' + data.id + '">'
                    +'<i class="fa fa-times-circle text-danger"></i></a>');
            } else {
                $('td', row).eq(3).empty().append('<input type="checkbox" class="hot-tags" data-tag-id="' + data.id + '" '
                    + (data.hot_tags.length ? 'checked="checked"' : '')
                    +'>');
            }
        },
    });

    $('.select-locale').on('change', function (e) {
        $('.tags-list').submit();
    });

    $(document).on('change', '.hot-tags', function () {
        var element = $(this);
        var tag = element.data('tag-id');
        var url = $('#tag-table').data('setting-url');

        $.ajax({
            url: url,
            type: 'POST',
            data: {tag_id: tag, locale_id: localeId},
        })
        .done(function(response) {
            if (response.status == 0) {
                swal($('#button-error').data('message'));
                location.reload();
            } else {
                swal($('#button-success').data('message'));
            }
        })
        .fail(function() {
        })
    });

    $(document).on('click', '.remove-hot-tag', function () {
        var element = $(this);
        var tag = element.data('tag-id');
        var url = $('#tag-table').data('setting-url');

        $.ajax({
            url: url,
            type: 'POST',
            data: {tag_id: tag, locale_id: localeId},
        })
        .done(function(response) {
            if (response.status == 0) {
                swal($('#button-error').data('message'));
                location.reload();
            } else {
                swal($('#button-success').data('message'));
                location.reload();
            }
        })
        .fail(function() {
        })
    });
});