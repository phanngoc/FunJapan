$(document).ready(function () {
    $('.article-content').markdown({
        autofocus:false,
        savable:false
    });

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
    $('#article-table tfoot th').each(function(index, element) {
        var title = $(this).text();
        if (index == 1 || index == 2 || index == 3 || index == 4) {
            $(this).html( '<input type="text" class="form-control filter-input" placeholder="Search '+title+'" />' );
        }
    });

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
            { 'data': 'locale_id' },
            { 'data': 'created_at' },
            { 'data': 'published_at' },
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
        }],
        'createdRow': function (row, data, index) {
            var pageInfo = table.page.info();
            $('td', row).eq(0).empty().append(pageInfo.page * pageInfo.length + index + 1);
            var detailLink = baseUrl() + '/admin/articles/' + data.article_id + '?locale=' + data.locale_id;
            $('td', row).eq(1).empty().append('<a href="' + detailLink + '">' + encodeHTML(data.title) + '</a>');
            $('td', row).eq(2).empty().append(locales[data.locale_id]);
            $('td', row).eq(5).empty().append(data.is_top_article ? 'Yes' : 'No');
            $('td', row).eq(6).empty().append(data.hide_always ? 'Yes' : 'No');
            $('td', row).eq(7).empty().append(data.is_member_only ? 'Yes' : 'No');
            var editLink = baseUrl() + '/admin/articles/' + data.article_id + '/edit/?locale=' + data.locale_id;
            $('td', row).eq(8).empty().append('<a href="' + editLink + '" class="edit"><i class="fa fa-pencil-square-o fa fa-lg"></i></a>'
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
            $('.date-time-campaign').removeClass('hidden');
        } else {
            $('.auto-approve-photo').addClass('hidden');
            $('.date-time-campaign').addClass('hidden');
        }
    }
}
