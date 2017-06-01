$(document).ready(function (e) {
    $('#survey-table').DataTable({
        paging: true,
        order: [[ 4, "desc" ]],
        searchDelay: 400,
        columns: [
            { 'data': 'id' },
            { 'data': 'title' },
            { 'data': 'type' },
            { 'data': 'point' },
            { 'data': 'created_at' },
        ],
        columnDefs: [{
            'targets': 0,
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': 5,
            'sortable': false,
            'searchable': false,
        }],
        fnDrawCallback: function (data, type, full, meta) {
            $('[data-toggle="tooltip"]').tooltip();
        },
    });

    $('input, .article-content, select').change(function () {
        $('#statusForm').data('status', 'change');
    });

    $(".cancel").click(function () {
        var status = $('#statusForm').data('status');
        var action = $(this).data('url');
        if (status == 'change') {
            var confirm = $(this).data('confirm');
            swal({
                title: confirm,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            }, function () {
                window.location.href = action;
            });
        } else {
            window.location.href = action;
        }
    });

    $('.select-locale').on('change', function (e) {
        $('.surveys-list').submit();
    });

    $('.delete').click(function() {
        var url = $(this).data('url');
        var token = $('meta[name="csrf-token"]').attr('content');
        var urlRedirect = $('#url-redirect').data('url');
        var confirm=$(this).data('confirm');
        swal({
            title: confirm,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5bc0de",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                headers: { 'X-CSRF-TOKEN' : token },
                type: 'DELETE',
                url: url,
                data: {},
                success: function (response) {
                    window.location.href = urlRedirect;
                },
                error: function (e) {
                    window.location.href = urlRedirect;
                }
            });
        });
    });
});