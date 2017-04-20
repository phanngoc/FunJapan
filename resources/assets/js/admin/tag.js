$(document).ready(function (e) {
    $('#tag-table').DataTable({
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
        'columnDefs': [{
            'targets': 3,
            'sortable': false,
            'class': 'text-center',
            'data': function () {
                return '<a href="#" class="edit"><i class="fa fa-pencil-square-o fa fa-lg"></i></a>'
                + '<a href="#" class="delete"><i class="fa fa-trash-o fa fa-lg"></i></a>';
            }
        }],
        'createdRow': function (row, data, index) {
            $('td', row).eq(3).attr('data-id', data.id);
        }
    });
})