$(document).ready(function() {
    var option =
        '<div class="form-group input-option">' +
            '<label class="option-name col-sm-1 control-label">Option</label>' +
            '<div class="col-sm-9">' +
                '<input name="option_name[]" id="option_name[]" type="text" class="form-control input-field">' +
            '</div>' +
            '<div class="col-sm-2">' +
                '<a class="add-option"><i class="fa fa-plus-square-o fa-lg"></i></a>' +
                '<a class="delete-option"><i class="fa fa-trash fa-lg"></i></a>' +
            '</div>' +
        '</div>';

    var question = '<hr>' + $('.form-create').html();

    $(document).on('change', '.question-type', function () {
        var selected_option = $(this).find('option:selected').val();
        var form_question = $(this).parents('.form-question').next();
        if (selected_option == checkbox || selected_option == radio) {
            form_question.html(option);
        } else {
            form_question.find('.input-option').remove();
        }
    });

    $(document).on('click', '.add-option', function () {
        $(this).parents('.option-question').append(option);
    });

    $(document).on('click', '.delete-option', function () {
        var input = $(this).parents('.input-option');
        if (!input.is(':first-child')) {
            input.remove();
        }
    });

    $(document).on('click', '.add-more', function () {
        $('.add-form').append(question);
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
        $.each($('.form-question'), function () {
            $.each($(this).next().find($('input[name="option_name[]"]')), function() {
                option_name.push($(this).val());
            });
            $.ajax({
                headers: { 'X-CSRF-TOKEN': token },
                type: 'POST',
                url: url,
                data: {
                    question_type: $(this).find('.question-type').val(),
                    title: $(this).find('.title').val(),
                    option_name: option_name
                },
                success: function success(response) {
                    window.location.href = $('#redirect-show').data('url');
                },
                error: function error(e) {
                    window.location.href = window.location.href;
                }
            });
            option_name = [];
        });
    });
});
