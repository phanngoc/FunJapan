function formatRepo (repo) {
    if (repo.loading) return repo.text;

    return '<div class="clearfix">'+ encodeHTML(repo.article_id + ' - ' + repo.title) + '</div>';
}

function formatRepoSelection (repo) {
    if (repo.selected) return repo.text;

    if (repo.article_id) {
        var textShow = repo.article_id + ' - ' + repo.title;
    } else {
        var textShow = repo.text;
    }

    if (textShow) {
        textShow = encodeHTML(textShow);
    }

    return textShow;
}

$(document).ready(function () {
    $('.article-select2').select2({
        placeholder: "Select a state",
        width: '96%',
        allowClear: true,
        ajax: {
            dataType: 'json',
            delay: 250,
            data: function data(params) {
                return {
                    key_word: params.term,
                    locale_id: $('#locale').val(),
                    banner_id: $('#form-edit').data('id'),
                    page: params.page
                };
            },
            processResults: function processResults(data, params) {
                params.page = params.page || 1;

                return {
                    results: data.data,
                    pagination: {
                        more: params.page * articleSuggest < data.total
                    }
                };
            },
            cache: true
        },

        escapeMarkup: function escapeMarkup(markup) {
            return markup;
        },
        minimumInputLength: 1,
        minimumResultsForSearch: -1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });
});

