$(document).ready(function() {
    var error =
        '<div class="error">' +
            '<p class="text-danger font-bold m-xxs error-option"></p>' +
            '<p class="text-danger font-bold m-xxs error-score"></p>' +
        '</div>';
    var option =
        '<div class="form-group input-option">' +
            '<label class="option-name col-sm-1 control-label">Option</label>' +
            '<div class="col-sm-4">' +
                '<input name="option_name[]" id="option_name[]" type="text" class="form-control input-field">' +
            '</div>' +
            '<label class="option-name col-sm-1 control-label">Score</label>' +
            '<div class="col-sm-4">' +
                '<input name="score[]" id="score[]" type="text" class="form-control input-field">' +
            '</div>' +
            '<div class="col-sm-2">' +
                '<a class="add-option"><i class="fa fa-plus-square-o fa-lg"></i></a>' +
                '<a class="delete-option"><i class="fa fa-trash fa-lg"></i></a>' +
            '</div>' +
            error +
        '</div>';

    var question = $('.form-create').html();
    var otherOption =
        '<div class="form-group other-option">' +
            '<label class="option-name col-sm-1 control-label">Other Option</label>' +
            '<div class="col-sm-9">' +
                '<input type="checkbox" class="other" name="other_option" value="1">' +
            '</div>' +
        '</div>';
    var deleteQuestion =
        '<div class="col-sm-2">' +
            '<a class="delete-question"><i class="fa fa-trash fa-lg"></i></a>' +
        '</div>';

    $(document).on('change', '.question-type', function () {
        var selected_option = $(this).find('option:selected').val();
        var form_question = $(this).parents('.form-question');
        form_question.find('.input-option').remove();
        form_question.find('.other-option').remove();
        if (selected_option == checkbox || selected_option == radio) {
            form_question.append(option + otherOption);
        }
    });

    $(document).on('click', '.add-option', function () {
        $(this).parents('.input-option').after(option);
    });

    $(document).on('click', '.delete-option', function () {
        var input = $(this).parents('.input-option');
        var formQuestion = $(this).parents('.form-question');
        if (formQuestion.find('.input-option').length > 1) {
            input.remove();
        }
    });

    $(document).on('click', '.add-more', function () {
        $('.form-create').append('<hr>' + question);
        $.each($('.question'), function () {
            if ($(this).find('.delete-question').length == 0) {
                $(this).append(deleteQuestion);
            }
        });
    });

    $(document).on('click', '.delete-question', function () {
        formQuestion = $(this).parents('.form-question');
        if ($('.form-question').length > 1) {
            if (formQuestion.is(':first-child')) {
                formQuestion.next('hr').remove();
            }
            formQuestion.prev('hr').remove();
            formQuestion.remove();
        }
    });

    $('.delete').click(function () {
        var url = $(this).data('url');
        var token = $('meta[name="csrf-token"]').attr('content');
        var urlRedirect = $('#url-redirect').data('url');
        swal({
            title: $('#delete-confirm').data('confirm-message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5bc0de",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': token },
                type: 'DELETE',
                url: url,
                data: {},
                success: function success(response) {
                    window.location.href = urlRedirect;
                },
                error: function error(e) {
                    window.location.href = urlRedirect;
                }
            });
        });
    });

    $('#create-question').click(function () {
        var url = $(this).data('url');
        var token = $('meta[name="csrf-token"]').attr('content');
        var option_name = [];
        var score = [];
        var formQuestion = [];
        var surveyId = $(this).data('survey-id');
        $.each($('.form-question'), function () {
            $.each($(this).find($('input[name="option_name[]"]')), function () {
                option_name.push($(this).val());
            });
            $.each($(this).find($('input[name="score[]"]')), function () {
                score.push($(this).val());
            });
            formQuestion.push({
                survey_id: surveyId,
                question_type: $(this).find('.question-type').val(),
                title: $(this).find('.title').val(),
                option_name: option_name,
                score: score,
                other_option: $(this).find('.other').is(':checked') ? 1 : 0
            });
            option_name = [];
            score = [];
        });

        $('.error-question').text('');
        $('.error-score').text('');
        $('.error-option').text('');
        $.ajax({
            headers: { 'X-CSRF-TOKEN': token },
            type: 'POST',
            url: url,
            data: {
                question: formQuestion
            },
            success: function success(response) {
                if (response.message) {
                    $.each(response.message, function (key, value) {
                        $('.form-question:eq(' + key + ')').find('.error-question').text(value.title);
                        if (value.score) {
                            $.each(value.score, function (keyScore, valueScore) {
                                $('.form-question:eq(' + key + ')').find('.error-score:eq(' + keyScore + ')').text(valueScore);
                            });
                        }
                        if (value.option_name) {
                            $.each(value.option_name, function (keyOption, valueOption) {
                                $('.form-question:eq(' + key + ')').find('.error-option:eq(' + keyOption + ')').text(valueOption);
                            });
                        }
                    });
                } else {
                    window.location.href = $('#redirect-show').data('url');
                }
            },
            error: function error(e) {
                window.location.href = window.location.href;
            }
        });
    });
});
