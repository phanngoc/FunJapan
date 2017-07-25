$(function () {
    $('.article-detail-action').on('click', '.btn-start, .btn-stop', function () {
        var element = $(this);
        var articleLocaleId = element.parents('.article-detail-action').attr('data-article-locale');
        var url = element.parents('.article-detail-action').attr('data-url');

        if (element.hasClass('btn-stop')) {
            var titleConfirm = element.parents('.article-detail-action').attr('data-stop-confirm');
        } else {
            var titleConfirm = element.parents('.article-detail-action').attr('data-start-confirm');
        }

        swal({
            title: titleConfirm,
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: element.attr('data-btn-yes'),
            cancelButtonText: element.attr('data-btn-cancel'),
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        'articleLocaleId': articleLocaleId
                    },
                    success: (response) => {
                        if (response.success) {
                            swal(response.message, '', 'success');
                            if (element.hasClass('btn-stop')) {
                                var textBtn = '<i class="fa fa-chevron-circle-right"></i> ';
                                textBtn += element.parents('.article-detail-action').attr('data-start-label');
                                element.removeClass('btn-stop').addClass('btn-start').html(textBtn);
                                var textLabel = '<i class="fa fa-stop-circle"></i> ';
                                textLabel += element.parents('.article-detail-action').attr('data-stop-label');
                                element.parents('.article-detail-action').find('.btn:first').removeClass()
                                    .addClass('btn btn-default btn-xs btn-w-m btn-label-stop').html(textLabel);
                            } else {
                                var textBtn = '<i class="fa fa-stop-circle"></i> ';
                                textBtn += element.parents('.article-detail-action').attr('data-stop-label');
                                element.removeClass('btn-start').addClass('btn-stop').html(textBtn);
                                var textLabel = '<i class="fa fa-level-up"></i> ';
                                textLabel += element.parents('.article-detail-action').attr('data-published-label');
                                element.parents('.article-detail-action').find('.btn:first').removeClass()
                                    .addClass('btn btn-default btn-xs btn-w-m btn-label-published').html(textLabel);
                            }
                        } else {
                            swal(response.message, '', 'error');
                        }

                    },
                    error: function (e) {
                    }
                });
            }
        });
    });
});
