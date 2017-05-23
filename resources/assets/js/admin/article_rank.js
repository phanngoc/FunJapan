$(document).ready(function () {
    var localeId = 1;
    var articleRank = {};
    changeSelect(localeId, articleRank);
    processSelect2(localeId);
    saveRanks(localeId, articleRank);

    $('.rank-tabs li').click(function () {
        var localeId = $(this).data('tab');
        changeSelect(localeId, articleRank);
        processSelect2(localeId);
        saveRanks(localeId, articleRank);
        $('#save-ranks-' + localeId).attr('disabled', 'disabled');
    });

    $('#save-ranks-' + localeId).attr('disabled', 'disabled');
});

function changeSelect(localeId, articleRank) {
    $('.choose-article-' + localeId).each(function () {
        var rank = $(this).data('rank');
        articleRank[rank] = $(this).val();
    });

    $('.choose-article-' + localeId).on("select2:select", function(e) {
        $('#save-ranks-' + localeId).removeAttr('disabled');
        var rank = $(this).data('rank');
        articleRank[rank] = $(this).val();
    });

    $('.choose-article-' + localeId).on("select2:unselect", function(e) {
        $('#save-ranks-' + localeId).removeAttr('disabled');
        var rank = $(this).data('rank');
        $(this).parent().find('#error-' + rank + '-' + localeId).text('');
        articleRank[rank] = null;
    });
}

function processSelect2(localeId) {
    $('.choose-article-' + localeId).select2({
        placeholder: "Select a article",
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: baseUrl() + '/admin/setting/ranks/' + localeId,
            dataType: 'json',
            data: function data(params) {
                return {
                    q: $.trim(params.term),
                    page: params.page
                };
            },
            processResults: function processResults(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.data,
                    pagination: {
                        more: params.page * perPage < data.total
                    }
                };
            },
        }
    });
}

function saveRanks(localeId, articleRank) {
    $('#save-ranks-' + localeId).click(function () {
        var element = $(this);
        $.each(articleRank, function(key, value) {
            $('#error-' + key + '-' + localeId).text('');
        });
        if (articleRank) {
            $.ajax({
                url: baseUrl() + '/admin/setting/ranks/' + localeId + '/store',
                type: 'POST',
                data: {
                    articleRank: articleRank
                },
                success: function (data) {
                    if (data.message) {
                        $.each(data.message, function (key, value) {
                            $.each(value, function (rank, duplicate) {
                                $('#error-' + rank + '-' + localeId).text(duplicate);
                            });
                            $(window).scrollTop(0);
                        });
                    } else {
                        $('#error-' + data.rank + '-' + localeId).text('');
                        swal(labelUpdateSuccess, "", "success");
                        $('#save-ranks-' + localeId).attr('disabled', 'disabled');
                    }
                }
            });
        }
    });
}
