$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    var result = $('.form-create').html();
    var deleteButton =
        '<div class="col-sm-1">' +
            '<a data-toggle="tooltip" data-placement="top" href="javascript:;" title="Delete Result" class="delete"><i class="fa fa-trash fa-lg"></i></a>' +
        '</div>';
    $('.add-more').click(function () {
        var form = $('.form-create').append('<hr>' + result);
        id = id + 1;
        formLast = $('.form-result').last();
        formLast.find('.result-id').val(id);
        formLast.find('.score_from').attr('name', 'result[' + id + '][required_point_from]');
        formLast.find('.score_to').attr('name', 'result[' + id + '][required_point_to]');
        formLast.find('.title').attr('name', 'result[' + id + '][title]');
        formLast.find('.photo').attr('name', 'result[' + id + '][photo]');
        formLast.find('.description').attr('name', 'result[' + id + '][description]');
        formLast.find('.bottom_text').attr('name', 'result[' + id + '][bottom_text]');
        $('[data-toggle="tooltip"]').tooltip();
        $.each($('.title'), function () {
            if ($(this).find('.delete').length == 0) {
                $(this).append(deleteButton);
            }
        });
        deleteResult();
        disabledDeleteResult();
    });

    $('.photo').on('change', function (e) {
        readUrl($(this), this);
    });

    $('#create-result, #edit-result').click(function () {
        var url = $(this).data('url');
        var token = $('meta[name="csrf-token"]').attr('content');
        var surveyId = $(this).data('survey-id');
        var result = [];
        var formData = new FormData($('#create-result-form')[0]);
        formData.append('survey_id', surveyId);

        $('.error-score-from').text('');
        $('.error-score-to').text('');
        $('.error-title').text('');

        $.ajax({
            headers: { 'X-CSRF-TOKEN': token },
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function success(response) {
                if (response.message) {
                    $.each(response.message, function (key, value) {
                        $('.form-result:eq(' + key + ')').find('.error-score-from').text(value.required_point_from);
                        $('.form-result:eq(' + key + ')').find('.error-score-to').text(value.required_point_to);
                        $('.form-result:eq(' + key + ')').find('.error-title').text(value.title);
                    });
                    $(window).scrollTop(0);
                } else {
                    window.location.href = $('#redirect-show').data('url');
                }
            },
            error: function error(e) {
                window.location.href = window.location.href;
            }
        });
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

    $('.delete').click(function () {
        formResult = $(this).parents('.form-result');
        if ($('.form-result').length > 1) {
            if (formResult.is(':first-child')) {
                formResult.next('hr').remove();
            }
            formResult.prev('hr').remove();
            formResult.remove();
        }
    });
});

function readUrl (input, element) {
    var oldImg = input.parents('.form-result').find('.preview-img');
    var oldUrl = oldImg.data('url');
    if (element.files && element.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            oldImg.attr('src', e.target.result);
        }

        reader.readAsDataURL(element.files[0]);
    } else {
        oldImg.attr('src', oldUrl);
    }
}

function disabledDeleteResult() {
    $('.delete').hover(function () {
        $(this).css('cursor', 'pointer');
    });

    $('.form-result:only-child').find('.delete').hover(function () {
        $(this).css('cursor', 'not-allowed');
    });
}

function deleteResult() {
    $('.delete').click(function () {
        formResult = $(this).parents('.form-result');
        if ($('.form-result').length > 1) {
            if (formResult.is(':first-child')) {
                formResult.next('hr').remove();
            }
            formResult.prev('hr').remove();
            formResult.remove();
        }

        disabledDeleteResult();
    });
}