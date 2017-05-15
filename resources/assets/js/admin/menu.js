$(document).ready(function() {
    var table = $('#sortable').sortable({
        stop: function(event, ui) {
            $('#update-order').removeClass('hidden');
        }
    });

    $('#update-order').on('click', function(e) {
        var data = $('#sortable').sortable('serialize');
        var url = $(e.target).data('url');

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
        })
        .done(function(data) {
            var  message = data;
            swal(
                {
                    title: data.message,
                    timer: 40000,
                },
                function() {
                    location.reload();
                }
            );
        })
        .fail(function() {

        })
    })

    if ((typeof oldInputs != 'undefined') && (typeof oldInputs.type != 'undefined')) {
        if (oldInputs.type != 'link') {
            $('#section_link').hide();
            $('#link').removeAttr('required');
        }
    }

    $('#type').on('change', function (e) {
        $('#link').val('');
        if ($(this).val() == 'link') {
            $('#section_link').show();
            $('#link').attr('required', 'required');
        } else {
            $('#section_link').hide();
            $('#link').removeAttr('required');
        }
    });

    $('.delete').on('click', function(e) {
        var url = $(this).data('url');
        swal({
            title: $('#delete-confirm').data('message'),
            text: $('#delete-warning').data('message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            $('#delete-menu-form').attr('action', url).submit();
        });
    });

    $('.info').on('click', function(e) {
        var data = $(this).data('info');
        $('#infoModal').modal('show');
    });

    $('.select-locale').on('change', function (e) {
        // var locale = $(this).val();
        // var action = $('.menus-list').attr('action');

        $('.menus-list').submit();
    });

    $('#type').on('change', function () {
        getCategoriesList();
    });

    $('#locale_id').on('change', function () {
        getCategoriesList();
    });

    $('.category-list').on('change', 'select', function () {
        var categoriesId = $(this).val();

        $('.category-selected table tbody').find('tr').each(function () {
            $(this).removeClass('hidden');
            if ($.inArray($(this).attr('data-id'), categoriesId) < 0) {
                $(this).addClass('hidden');
            }
        });

        var selectedCategories = [];
        $('.category-selected table tbody').find('tr').each(function () {
            if (!$(this).hasClass('hidden')) {
                selectedCategories.push($(this).attr('data-id'));
            }
        });

        $('.category-selected-hidden').val(selectedCategories.join(','));
    });

    $('.sortable-category').sortable({
        stop: function(event, ui) {
            var selectedCategories = [];
            $('.category-selected table tbody').find('tr').each(function () {
                if (!$(this).hasClass('hidden')) {
                    selectedCategories.push($(this).attr('data-id'));
                }
            });
            $('.category-selected-hidden').val(selectedCategories.join(','));
        }
    });
});

getCategoriesList = function () {
    if ($('#type').val() == 'category') {
        $.ajax({
            'url': urlGetCategories,
            'type': 'GET',
            'data': {
                localeId: $('#locale_id').val(),
            },
            success: (response) => {
                if (response.success) {
                    var options = '';
                    var tbody = '';

                    for (let key in response.categories) {
                        options += '<option value="' + key + '">' + response.categories[key] + '</option>';
                        tbody += '<tr class="hidden" data-id="' + key + '"><td>' + response.categories[key] + '</td></tr>';
                    }

                    $('.category-list').removeClass('hidden');
                    $('.category-selected').removeClass('hidden');
                    $('.category-list select').empty().append(options);
                    $('.category-selected table tbody').empty().append(tbody);
                }
            }
        });
    } else {
        $('.category-list').addClass('hidden');
        $('.category-selected').addClass('hidden');
    }
}
