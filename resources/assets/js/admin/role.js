$(function () {
    $('body').on('change', '.change-role', function () {
        var thisElement = $(this);
        var roleId = $(this).val();

        $.ajax({
            'url': thisElement.attr('data-url'),
            'type': 'POST',
            data: {
                userId: thisElement.attr('data-user-id'),
                roleId: roleId
            },
            success: (response) => {
                if (response.success) {
                    swal(response.message, '', 'success');
                } else {
                    swal(response.message, '', 'error');
                }
            }
        });
    });

    $('body').on('click', '.role-delete', function () {
        var thisElement = $(this);

        swal({
            title: thisElement.attr('data-message-confirm') + thisElement.attr('data-title') + '?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: thisElement.attr('data-yes-confirm'),
            cancelButtonText: thisElement.attr('data-cancel-confirm'),
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    'url': thisElement.attr('data-url'),
                    'type': 'DELETE',
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
