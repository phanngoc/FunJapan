$(document).ready(function () {
    $('.article-content').markdown({
        autofocus:false,
        savable:false
    });

    $('.article-tag').tagsinput({
        typeahead: {
            source: function(query) {
                return $.get($('.article-tag').data('url') + '/?query='+ query);
            },
            afterSelect: function(val) { this.$element.val(""); },
            items: 5,
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
    $('#article-table tfoot th').each(function(index, element) {
        var title = $(this).text();
        if (index != 4) {
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="Search '+title+'" />' );
        }
    });

    var table = $('#article-table').DataTable({
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
            { 'data': 'locale_id' },
            { 'data': 'created_at' },
        ],
        'columnDefs': [{
            'targets': 4,
            'sortable': false,
            'searchable': false,
            'class': 'text-center',
            'data': function () {
                return '';
            }
        }],
        'createdRow': function (row, data, index) {
            detailLink = baseUrl() + '/admin/articles/' + data.article_id + '?locale=' + data.locale_id;
            $('td', row).eq(1).empty().append('<a href="' + detailLink + '">' + data.title + '</a>');
            $('td', row).eq(2).empty().append(locales[data.locale_id]);
            $('td', row).eq(4).empty().append('<a href="#" class="edit"><i class="fa fa-pencil-square-o fa fa-lg"></i></a>'
                + '<a href="#" class="delete"><i class="fa fa-trash-o fa fa-lg"></i></a>');
        }
    });

    table.columns().every( function () {
        var that = this;

        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        });
    });

    $('.datetime-picker').datetimepicker({
        format: 'Y-m-d H:i'
    });

    addAutoApprovePhoto($('.select-type'));

    $('.select-type').on('change', function () {
        addAutoApprovePhoto($(this));
    });
});

function addAutoApprovePhoto (element) {
    if (typeof typePhoto != 'undefined') {
        if (element.val() == typePhoto) {
            $('.auto-approve-photo').removeClass('hidden');
        } else {
            $('.auto-approve-photo').addClass('hidden');
        }
    }
}
