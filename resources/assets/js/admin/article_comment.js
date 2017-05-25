$(document).ready(function (e) {

    $('.datetime-picker').datetimepicker({
        format: 'Y-m-d H:i'
    });

    var tableComment = $('#article-comment-table').DataTable({
        'processing': true,
        'serverSide': true,
        'searchDelay': 400,
        'aaSorting': [[ 4, 'desc' ]],
        "language": {
            "infoFiltered": ''
        },
        'ajax': {
            'url': $('#article-comment-table').data('url'),
            'type': 'GET',
            'data' : function ( d ) {
                d.locale_id = $('#locale_id').val();
            },
        },
        'columns': [
            { 'data': 'id' },
            { 'data': 'content' },
            { 'data': 'favorite_count' },
            { 'data': 'name' },
            { 'data': 'created_at' },
        ],
        'columnDefs': [{
            'targets': 5,
            'sortable': false,
            'searchable': false,
            'data': function () {
                return '';
            }
        },
        {
            'targets': 0,
            'sortable': false,
        },
        {
            'targets': [0,2,4],
            'class': 'text-center',
        }
        ],

        'createdRow': function (row, data, index) {
            var pageInfo = tableComment.page.info();
            $('td', row).eq(0).empty().append(pageInfo.page * pageInfo.length + index + 1);
            $('td', row).eq(1).empty().append(encodeHTML(data.content));
            $('td', row).eq(2).empty().append(data.favorite_count);
            $('td', row).eq(3).empty().append(data.name ? encodeHTML(data.name) : '');
            $('td', row).eq(4).empty().append(data.created_at);
            $('td', row).eq(5).empty().append('<div class="text-center"><a href="#" data-id="'+ data.id +'" data-confirm="'+ encodeHTML(data.confirm) +'" class="deleteArticleComment" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o fa fa-lg"></i></a></div>');
        },
    });

    $( 'body' ).on( 'click', '.deleteArticleComment', function (e) {
        var url = $(this).data('url');
        var token = $('meta[name="csrf-token"]').attr('content');
        var urlRedirect = $('#url-redirect').data('url');
        var confirm=$(this).data('confirm');
        var action  = $('#actionUrl').data('url');
        var urlAction = action + '/' + $(this).data('id');

        swal({
            title: confirm,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            $('#delete-article-comment-form').attr('action', urlAction).submit();
        });
    });

    $('.select-locale').on('change', function (e) {
        tableComment.search('');
        tableComment.ajax.reload(null,true);
    });

});
