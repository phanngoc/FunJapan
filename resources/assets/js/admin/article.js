$(document).ready(function () {
    $('.article-content').markdown({
        autofocus:false,
        savable:false
    });

    $('.article-tag').tagsinput({
        typeahead: {
            source: function(query) {
                return $.get($('.article-tag').data('url') + '/?query='+ query);
            },
            afterSelect: function(val) { this.$element.val(""); },
            items: 5,
        },
        freeInput: true,
    });

    $('.bootstrap-tagsinput input').on('keypress', function(e) {
        if (e.keyCode == 13) {
            e.keyCode = 188;
            e.preventDefault();
        };
    });

    $('#locale').on('change', function(e) {
        var localeId = $('#locale').val();
        $('#category').empty();
        $.each(categories[localeId], function(index, val) {
            var option = '<option value="' + val.category_id + '">' + val.name + '</option>';
            $('#category').append(option);
        });
    })
});

