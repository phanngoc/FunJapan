$(function () {
    $.fn.dataTable.ext.errMode = 'none';

    var table = $('#article-table').DataTable({
        'order': [[ 3, 'desc' ]],
        'processing': true,
        'serverSide': true,
        'searchDelay': 400,
        'language': {
            'infoFiltered': ''
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
            'class': 'min-width-160',
        },
        {
            'targets': 3,
            'class': 'text-center min-width-160',
        },
        {
            'targets': 4,
            'class': 'text-center min-width-160',
        },
        {
            'targets': 5,
            'sortable': false,
            'searchable': false,
            'class': 'text-center',
            'data': function () {
                return '';
            }
        }],
        'createdRow': function (row, data, index) {
            var pageInfo = table.page.info();
            $('td', row).eq(0).empty().html(pageInfo.page * pageInfo.length + index + 1);
            var detailLink = baseUrl() + '/admin/articles/' + data.article_id + '?locale=' + data.locale_id;
            $('td', row).eq(1).empty().html('<a href="' + detailLink + '">' + encodeHTML(data.title) + '</a>');
            $('td', row).eq(2).empty().text(data.article.user.name);

            if (typeof flag != 'undefined' && flag) {
                $('td', row).eq(5).empty().html('<input type="checkbox" class="select-article"' +
                    'data-article-locale-id="' + data.id + '"' +
                    (data.recommended ? 'checked>' : '>'));
            } else {
                $('td', row).eq(5).empty().html('<a href="javascript:;" class="remove-recommended-article"' +
                'data-id="' + data.id + '"' +
                'data-title="' + encodeHTML(data.title) + '"' +
                'data-url="' + baseUrl() + '/admin/recommend-articles/' + data.id + '">' +
                '<i class="fa fa-times-circle text-danger"></i></a>');
            }
        }
    });

    $('.select-locale').on('change', function () {
        $('form.articles-list').submit();
    });

    $('body').on('click', '.select-article', function () {
        var element = $(this);
        var articleLocaleId = element.attr('data-article-locale-id');
        var url = $('#article-table').attr('data-url-set-recommend');

        $.ajax({
            'url': url,
            'type': 'POST',
            'data': {
                articleLocaleId: articleLocaleId,
            },
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: (response) => {
                if (!response.success) {
                    swal(response.message, '', 'error');
                    element.attr('checked', false);
                }
            }
        });
    });

    $('body').on('click', '.remove-recommended-article', function () {
        var element = $('#article-table');
        var thisElement = $(this);
        var articleLocaleId = thisElement.attr('data-id');

        swal({
            title: element.attr('data-message-confirm') + thisElement.attr('data-title'),
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
                    'url': thisElement.attr('data-url'),
                    'type': 'DELETE',
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: (response) => {
                        if (response.success) {
                            swal(response.message, '', 'success');
                            thisElement.parents('tr').remove();
                        } else {
                            swal(response.message, '', 'error');
                        }
                    }
                });
            }
        });
    });
});
