$(document).ready(function () {
    var keyword;
    var sortBy;
    var page;
    $('#client').on('keypress', function(e) {
        if (e.keyCode == 13) {
            return false;
        };
    });

    $('#client').on('click', '#create-client', function () {
        var item = $(this);
        item.prop('disabled', true);
        var url = $(this).data('url');
        var formData = new FormData($('#client-form')[0]);
        var action = $('.action:has(.edit-client)').html();
        $('.error-client-name').text('');
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function success(data) {
                if (data.message) {
                    $.each(data.message, function (key, value) {
                        $('.error-client-name').text(value);
                        item.parents('#client-form').find('input[name="name"]').focus();
                    });
                    $(window).scrollTop(0);
                } else {
                    swal({
                        title: labelCreateSuccess,
                        text: "",
                        type: "success"
                    });
                    renderTable(keyword = null, sortBy = 'id.desc', page = 1);
                    $('#name').val('');
                    $('#client').find('input[name="keyword"]').val('');
                }

                item.prop('disabled', false);
            }
        });
    });

    var error = '<p class="error-name text-danger font-bold"></p>';
    $('#client').on('click', '.edit-client', function () {
        var html = $(this).parents('tr').find('td.client-name').text();
        var input = $('<input class="form-control" type="text" name="name" value="">' + error);
        input.val(html);
        $(this).parents('tr').find('td.client-name').html(input);
        $(this).parents('tr').find('input').focus();

        $(this).html('<i class="fa fa-pencil"></i>&nbsp;Update');
        $(this).removeClass('edit-client').addClass('update-client');
    });

    $('#client').on('click', '.update-client', function () {
        var item = $(this);
        var clientId = $(this).parents('tr').find('td.client-name').data('id');
        if (clientId) {
            $.ajax({
                url: baseUrl() + '/admin/clients/' + clientId,
                type: 'PUT',
                data: {
                    name: $(this).parents('tr').find('input[name="name"]').val()
                },
                success: function success(data) {
                    if (data.message) {
                        $.each(data.message, function (key, value) {
                            item.parents('tr').find('.error-' + key).text(value);
                            item.parents('tr').find('input[name="name"]').focus();
                        });
                    } else {
                        swal({
                            title: labelUpdateSuccess,
                            text: "",
                            type: "success"
                        });
                        renderTable();
                    }
                }
            });
        }
    });

    $('#client').on('click', '#search-client', function () {
        keyword = $(this).parents('.form-search').find('input[name="keyword"]').val();
        renderTable(keyword, sortBy, page);
    });

    var inputSortBy = $('#client').find('input[name="sortBy"]');
    var sortAscClass = 'sort-asc';
    var sortDescClass = 'sort-desc';

    var inputSortByVal = inputSortBy.val().split('.');

    $('#client').find('.sort').each(function (index) {
        var el = $(this);
        var sortName = el.data('sort-name');

        if (inputSortByVal && inputSortByVal[0] == sortName) {
            el.addClass('sort-' + inputSortByVal[1]);

            return false;
        }
    });

    $('#client').on('click', '.sort', function () {
        var el = $(this);
        var sortName = el.data('sort-name');

        if (el.hasClass(sortDescClass)){
            el.removeClass(sortAscClass);
            el.addClass(sortDescClass);
            inputSortBy.val(sortName + '.' + 'asc');
        } else {
            el.removeClass(sortAscClass);
            el.addClass(sortDescClass);
            inputSortBy.val(sortName + '.' + 'desc');
        }

        renderTable(keyword, inputSortBy.val(), page);
    });

    $('#client').on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        renderTable(keyword, inputSortBy.val(), page);
    });
});
