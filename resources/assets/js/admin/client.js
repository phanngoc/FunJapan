$(document).ready(function () {
    var keyword;
    var limit;
    var sortBy;
    var page;
    $('#client').on('click', '#create-client', function () {
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
                    });
                    $(window).scrollTop(0);
                } else {
                    swal({
                        title: labelCreateSuccess,
                        text: "",
                        type: "success"
                    });
                    renderTable();
                    $('#name').val('');
                }
            }
        });
    });

    var error = '<p class="error-name text-danger font-bold"></p>';
    $('#client').on('click', '.edit-client', function () {
        var html = $(this).parents('tr').find('td.client-name').html();
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
                            $('.error-' + key).text(value);
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
        renderTable(keyword, limit, sortBy, page);
    });

    $('#client').on('change', '#show-item', function () {
        limit = $(this).val();
        renderTable(keyword, limit, sortBy, page);
    });

    var inputSortBy = $('input[name="sortBy"]');
    var sortAscClass = 'sort-asc';
    var sortDescClass = 'sort-desc';

    var inputSortByVal = inputSortBy.val().split('.');

    var useDefaultSort = true;
    $('.sort').each(function (index) {
        var el = $(this);
        var sortName = el.data('sort-name');

        if (inputSortByVal && inputSortByVal[0] == sortName) {
            el.addClass('sort-' + inputSortByVal[1]);
            useDefaultSort = false;

            return false;
        }
    });

    if (useDefaultSort) {
        $('.default-sort').first().addClass(sortAscClass);
    }

    var changeSort = function (el, curentSort, newSort, sortName) {
        $('.' + curentSort).removeClass(curentSort);
        el.removeClass(curentSort);
        el.addClass(newSort);
        if (newSort == sortAscClass) {
            inputSortBy.val(sortName + '.' + 'asc');
        } else {
            inputSortBy.val(sortName + '.' + 'desc');
        }
    }

        $('#client').on('click', '.sort', function () {
        var el = $(this);
        var sortName = el.data('sort-name');

        if (el.hasClass(sortAscClass)) {
            changeSort(el, sortAscClass, sortDescClass, sortName);
        } else {
            changeSort(el, sortDescClass, sortAscClass, sortName);
        }
        renderTable(keyword, limit, inputSortBy.val(), page);
    });

    $('#client').on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        renderTable(keyword, limit, inputSortBy.val(), page);
    });
});
