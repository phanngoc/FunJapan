$(document).ready(function (e) {
    $('.delete').click(function() {
        var url = $(this).data('url');
        var token = $('meta[name="csrf-token"]').attr('content');
        var urlRedirect = $('#url-redirect').data('url');
        var confirm=$(this).data('confirm')
        swal({
            title: confirm,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
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

    $('#category-table').DataTable( {
        aLengthMenu: [[10, 25, 50], [10, 25, 50]],
        paging: true,
        pagingType: 'full_numbers',
        order: [],
        'columnDefs': [{
            'targets': 3,
            'sortable': false,
            'searchable': false
        },
        {
            'targets': 6,
            'sortable': false,
            'searchable': false
        }]
    });
});