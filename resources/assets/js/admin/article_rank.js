$(document).ready(function () {
    var articleRank = {};
    var localeId = 1;
    changeSelect(localeId, articleRank);
    processSelect2(localeId);
    unselect2(localeId);
    saveRanks(localeId, articleRank);

    $('.rank-tabs li').click(function () {
        var localeId = $(this).data('tab');
        changeSelect(localeId, articleRank);
        processSelect2(localeId);
        unselect2(localeId);
        saveRanks(localeId, articleRank);
        $('.choose-article-' + localeId).on('select2:select', function() {
            $('#save-ranks-' + localeId).removeAttr('disabled');
        });

        $('#save-ranks-' + localeId).attr('disabled', 'disabled');
    });

    $('.choose-article-' + localeId).on('select2:select', function() {
        $('#save-ranks-' + localeId).removeAttr('disabled');
    });

    $('#save-ranks-' + localeId).attr('disabled', 'disabled');
});

function changeSelect(localeId, articleRank) {
    $('.choose-article-' + localeId).change(function() {
        var rank = $(this).data('rank');
        var articleLocaleId = $(this).children().last().val();
        if (articleRank.hasOwnProperty(rank)) {
            delete articleRank[rank];
        }
        articleRank[rank] = articleLocaleId;
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

function unselect2(localeId) {
    $('.choose-article-' + localeId).on('select2:unselecting', function() {
        var unselect = $(this).val();
        var rank = $(this).data('rank');
        $(this).find('option').remove();
        $('#save-ranks-' + localeId).removeAttr('disabled');
        $('#save-ranks-' + localeId).click(function () {
            $.ajax({
                url: baseUrl() + '/admin/setting/ranks/' + localeId + '/delete',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    articleLocaleId: unselect,
                    rank: rank
                },
                success: function (data) {
                }
            });
        });
    }).trigger('change');
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
