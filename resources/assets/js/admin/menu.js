$(document).ready(function() {
    var table = $('#sortable').sortable({
        stop: function(event, ui) {
            $('#update-order').removeClass('hidden');
        }
    });

    $('#update-order').on('click', function(e) {
        var data = $('#sortable').sortable('serialize');
        var url = $(e.target).data('url');

        $('#update-order-form').attr('action', url + '?' + data).submit();
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
        var text = $(this).data('warning');
        swal({
            title: $('#delete-confirm').data('message'),
            text: text,
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

    $('.select-locale').on('change', function (e) {
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

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })

    $('.cancel').on('click', function(e) {
        e.preventDefault();
        var message = $(this).data('message');
        url = $(this).attr('href');;
        swal({
            title: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            location.href = url;
        });
    });

    $('#icon').on('change', function (e) {
        readUrl(this);
    });
});

function readUrl (input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview-section').show();
            $('#preview-img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        $('#preview-section').hide();
    }
}

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
