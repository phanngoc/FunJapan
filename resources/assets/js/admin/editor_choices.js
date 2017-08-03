function formatRepo (repo) {
    if (repo.loading) return repo.text;

    return '<div class="clearfix">'+ encodeHTML(repo.title) + '</div>';
}

function formatRepoSelection (repo) {
    if (repo.selected) return repo.text;

    var textShow = repo.title || repo.summary;

    if (textShow) {
        textShow = encodeHTML(textShow);
    }
    return textShow;
}

$(document).ready(function(e) {
    $('#choice').on('click', function(){
        var input = $('#url-input').val();
        var url = $(this).data('url');
        var element = $(this);
        $.ajax({
            url: url,
            type: 'POST',
            data: {url: input},
        })
        .done(function(response) {
            if (response.status == 0) {
                $('#error-message').empty().text(response.message);
                $('#error-message').parent().parent().removeClass('hidden');
            } else {
                swal(response.message, null, 'success');
                var insertText =
                '<div class="row margin-bottom-10">'
                    + '<div class="col-lg-1 text-center mt7 no">'
                        + '<button class="btn btn-info m-r-sm btn-circle btn-lg">' + response.data.number_record + '</button>'
                    + '</div>'
                    + '<div class="col-lg-3 text-center" id="preview-section"><img id="thumbnail-' + response.data.id
                    + '" src="' + response.data.thumbnail.normal + '"></div>'
                    + '<div class="col-lg-4 text-center link mt20" id="link-' + response.data.id + '">' + response.data.link + '</div>'
                    + '<div class="col-lg-2 text-center mt15">'
                        + '<button class="btn btn-primary modify" id="modify-' + response.data.id
                        + '" data-id="' + response.data.id + '">' + $('#modify-button').data('message') + '</button>'
                    + '</div>'
                    + '<div class="col-lg-2 text-center mt15">'
                        + '<button class="btn btn-primary delete" id="delete-' + response.data.id
                        + '" data-id="' + response.data.id + '">' + $('#delete-button').data('message') + '</button>'
                    + '</div>'
                + '</div>'
                + '<hr>';

                $(insertText).insertBefore(element.parent().parent());
                $('#add-section').addClass('hidden');
                $('#no-article-section').next().remove();
                $('#no-article-section').remove();
                $('#url-input').val('');
                $('#error-message').parent().parent().addClass('hidden');
                if (response.data.number_record == 10) {
                    $('#add-form').addClass('hidden');
                }
            }
        })
    });
    $('#add-form').on('click', function() {
        $('.article-select2#url-input').select2('val', '');
        $('#add-section').removeClass('hidden');
    })

    $(document).on('click', '.modify', function() {
        $('.article-select2#update-url-input').select2('val', '');
        var editorChoiceId = $(this).data('id');
        $('#update-url-input').attr('data-id', editorChoiceId);
        $('#update-section').removeClass('hidden');
        $('#editor-choices-id').text($(this).parent().siblings('.no').children().text());
    });

    $(document).on('click', '.delete', function() {
        var editorChoiceId = $(this).data('id');
        var url = $('#delete-url').data('url');
        var element = $(this);

        swal({
            title: $('#delete-message').data('message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url: url,
                type: 'POST',
                data: {id: editorChoiceId},
            })
            .done(function(response) {
                if (response.status == 0) {
                    swal(response.message, null, 'error');
                } else {
                    element.parent().parent().next('hr').remove();
                    element.parent().parent().remove();
                    if (response.number_record == 0) {
                        var insertText =
                            '<div class="row" id="no-article-section">'
                                + '<div class="col-lg-12">'
                                    + $('#no-article-message').data('message')
                                + '</div>'
                            + '</div>'
                            + '<hr>';
                        $('#editor-choices-content').prepend(insertText);
                    } else {
                        var numberElement = $('.btn-circle');
                        $.each(numberElement, function(index, val) {
                            $(val).text(index + 1);
                        });
                    }
                    swal(response.message, null, 'success');
                    $('#add-form').removeClass('hidden');
                }
            })
        });
    });

    $(document).on('click', '#update', function() {
        var input = $('#update-url-input').val();
        var editorChoiceId = $('#update-url-input').attr('data-id');
        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'POST',
            data: {id: editorChoiceId, url: input},
        })
        .done(function(response) {
            if (response.status == 0) {
                $('#update-error-message').empty().text(response.message);
                $('#update-error-message').parent().parent().removeClass('hidden');
            } else {
                swal(response.message, null, 'success');
                $('#thumbnail-' + response.data.id).attr('src', response.data.thumbnail.normal);
                $('#link-' + response.data.id).text(response.data.link);
                $('#update-section').addClass('hidden');
                $('#update-error-message').parent().parent().addClass('hidden');
            }
        })
    });

    $('#cancel-add').on('click', function() {
        $('#add-section').addClass('hidden');
        $('#error-message').parent().parent().addClass('hidden');
    });

    $('#cancel-update').on('click', function() {
        $('#update-section').addClass('hidden');
        $('#update-error-message').parent().parent().addClass('hidden');
    });
})
