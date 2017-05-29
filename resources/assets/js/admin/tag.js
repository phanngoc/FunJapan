$(document).ready(function (e) {
    var table = $('#tag-table').DataTable({
        'order': [[ 3, "desc" ]],
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
            { 'data': 'status' },
            { 'data': 'created_at' },
        ],
        'columnDefs': [{
            'targets': 0,
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': 3,
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
            editLink = baseUrl() + '/admin/tags/' + data.id + '/edit';
            blockAction = baseUrl() + '/admin/tagBlock/' + data.id;
            var appendText = '';
            if (data.status == 0) {
                $('td', row).eq(2).empty().append($('#tag-not-block').data('message'));

                appendText = '<a data-toggle="tooltip" data-placement="right" title="'
                    + $('#button-block').data('message')
                    + '" href="#"><i data-url="'
                    + blockAction
                    + '" class="fa fa-ban fa fa-lg ban"></i></a>';
            } else {
                $('td', row).eq(2).empty().append($('#tag-block').data('message'));

                appendText ='<a data-toggle="tooltip" data-placement="right" title="'
                    + $('#button-unblock').data('message')
                    + '" href="#"><i data-url="'
                    + blockAction
                    + '" class="fa fa-undo fa fa-lg unBan"></i></a>';
            }
            $('td', row).eq(1).empty().append('<a href="' + baseUrl() + '/admin/tags/' + data.id + '">' + encodeHTML(data.name) + '</a>');
            $('td', row).eq(4).empty().append('<a data-toggle="tooltip" data-placement="left" title="'
                + $('#button-edit').data('message')
                +'" href="'
                + editLink
                + '" class="edit"><i class="fa fa-pencil-square-o fa fa-lg"></i></a>'
                + '<a data-toggle="tooltip" data-placement="top" title="'
                + $('#button-delete').data('message')
                +'" href="#" class="delete"><i data-id="'
                + data.id
                + '" class="fa fa-trash fa fa-lg"></i></a>'
                + appendText);
        },
        'fnDrawCallback': function (data, type, full, meta) {
            $('[data-toggle="tooltip"]').tooltip();
        },
    });

    $(document).on('click', '.delete', function (e) {
        deleteAction = baseUrl() + '/admin/tags/' + $(e.target).data('id');
        swal({
            title: $('#delete-confirm').data('message'),
            text: $('#delete-warning').data('message'),
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

    $(document).on('click', '.ban', function (e) {
        blockAction = $(e.target).data('url');
        swal({
            title: $('#block-confirm').data('message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url: blockAction,
                type: 'POST',
            })
            .done(function(response) {
                if (response.status == 1) {
                    $(e.target).removeClass('ban');
                    $(e.target).removeClass('fa-ban');
                    $(e.target).addClass('unBan');
                    $(e.target).addClass('fa-undo');
                    $(e.target).parent().attr('data-original-title', $('#button-unblock').data('message'));
                    swal.close();
                } else {
                    swal($('#button-error').data('message'));
                }
            })
            .fail(function() {
            })
        });
    });

    $(document).on('click', '.unBan', function (e) {
        blockAction = $(e.target).data('url');
        swal({
            title: $('#un-block-confirm').data('message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url: blockAction,
                type: 'POST',
            })
            .done(function(response) {
                if (response.status == 1) {
                    $(e.target).removeClass('unBan');
                    $(e.target).removeClass('fa-undo');
                    $(e.target).addClass('ban');
                    $(e.target).addClass('fa-ban');
                    $(e.target).parent().attr('data-original-title', $('#button-block').data('message'));
                    swal.close();
                } else {
                    swal($('#button-error').data('message'));
                }
            })
            .fail(function() {
            })
        });

    });
})
