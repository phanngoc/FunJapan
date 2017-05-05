$(document).ready(function (e) {
    $('.delete').click(function() {
        var url = $(this).data('url');
        var token = $('meta[name="csrf-token"]').attr('content');
        var urlRedirect = $('#url-redirect').data('url');
        swal({
            title: $('#delete-confirm').data('confirm-message'),
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
        aLengthMenu: [[20, 50, 100], [20, 50, 100]],
        paging: true,
        order: []
    });
});