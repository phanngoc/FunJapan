$(function () {
    $('.select-locale').on('change', function () {
        $('form.articles-list').submit();
    });

    $('body').on('click', '.select-article', function () {
        var element = $(this);

        if (element.prop('checked') == true) {
            addPopular(element);
        } else {
            deletePopular(element, true)
        }
    });

    $('body').on('click', '.remove-popular-article', function () {
        deletePopular($(this), false)
    });

    function addPopular(element)
    {
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
            success: function (response) {
                if (response.success) {
                    $('.popular-articles-list').prepend(response.html);
                } else {
                    element.prop('checked', false);
                    swal(response.message, '', 'error');
                }
            }
        });
    }

    function deletePopular(element, fromArticleList)
    {
        var articleLocaleId = element.attr('data-article-locale-id');

        swal({
            title: lblConfirmRemovePopular,
            text: lblConfirmRemovePopularTitle,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: lblButtonYes,
            cancelButtonText: lblButtonNo,
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                var url = element.attr('data-url');

                if (fromArticleList) {
                    url = url + '/' + articleLocaleId;
                }

                $.ajax({
                    'url': url,
                    'type': 'DELETE',
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        if (response.success) {
                            swal(response.message, '', 'success');

                            $('.popular-articles-list').find('tr').each(function () {
                                if (articleLocaleId == $(this).attr('data-id')) {
                                    $(this).remove();
                                }
                            });

                            $('.articles-list').find('tr').each(function () {
                                if (articleLocaleId == $(this).attr('data-id')) {
                                    $(this).find('.select-article').attr('checked', false);
                                }
                            });
                        } else {
                            swal(response.message, '', 'error');
                            if (fromArticleList) {
                                element.prop('checked', true);
                            }
                        }
                    }
                });
            } else {
                if (fromArticleList) {
                    element.prop('checked', true);
                }
            }
        });
    }
});
