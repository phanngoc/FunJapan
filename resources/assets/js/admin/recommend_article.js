$(function () {
    $('.select-locale').on('change', function () {
        $('form.articles-list').submit();
    });

    $('body').on('click', '.select-article', function () {
        var element = $(this);
        var articleLocaleId = element.attr('data-article-locale-id');

        $.ajax({
            'url': element.attr('data-url'),
            'type': 'POST',
            'data': {
                articleLocaleId: articleLocaleId,
            },
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: (response) => {
                if (response.success) {
                    if (response.recommended) {
                        $('.recommended-articles-list').prepend(response.html);
                    } else {
                        $('.recommended-articles-list').find('tr').each(function () {
                            if (articleLocaleId == $(this).attr('data-id')) {
                                $(this).remove();
                            }
                        });
                    }
                } else {
                    swal(response.message, '', 'error');
                }
            }
        });
    });

    $('body').on('click', '.remove-recommended-article', function () {
        var element = $(this);
        var articleLocaleId = element.attr('data-id');

        swal({
            title: element.attr('data-title-confirm'),
            text: element.attr('data-message-confirm'),
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: element.attr('data-yes-confirm'),
            cancelButtonText: element.attr('data-no-confirm'),
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    'url': element.attr('data-url'),
                    'type': 'DELETE',
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: (response) => {
                        if (response.success) {
                            swal(response.message, '', 'success');
                            element.parents('tr').remove();

                            $('.articles-list').find('tr').each(function () {
                                if (articleLocaleId == $(this).attr('data-id')) {
                                    $(this).find('.select-article').attr('checked', false);
                                }
                            });
                        } else {
                            swal(response.message, '', 'error');
                        }
                    }
                });
            }
        });
    });
});
