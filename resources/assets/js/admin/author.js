$(document).ready(function () {
    var keyword;
    var limit;
    var sortBy;
    var page;
    var tab = 'author';
    $('#author').on('click', '#create-author', function () {
        var url = $(this).data('url');
        var formData = new FormData($('#author-form')[0]);
        var action = $('.action:has(.edit-author)').html();
        $('.error-name').text('');
        $('.error-photo').text('');
        $('.error-description').text('');
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function success(data) {
                if (data.message) {
                    $.each(data.message, function (key, value) {
                        $('.error-' + key).text(value);
                    });
                    $(window).scrollTop(0);
                } else {
                    swal({
                        title: labelCreateSuccess,
                        text: "",
                        type: "success"
                    });
                    renderTable(keyword, limit, sortBy, page, tab);

                    $('input').val('');
                    $('#preview-section').hide();
                }
            }
        });
    });

    var errorName = '<p class="error-table-name text-danger font-bold"></p>';
    var errorPhoto = '<p class="error-table-photo text-danger font-bold"></p>';
    var errorDescription = '<p class="error-table-description text-danger font-bold"></p>';

    $('#author').on('click', '.edit-author', function () {
        var htmlName = $(this).parents('tr').find('td.author-name').html();
        var inputName = $('<input class="form-control" type="text" name="name" value="">' + errorName);
        inputName.val(htmlName);
        $(this).parents('tr').find('td.author-name').html(inputName);
        var htmlPhoto = $(this).parents('tr').find('td img').attr('src');
        var inputPhoto = $('<input type="file" accept="image/jpeg,image/png,image/jpg" id="photo-table" name="photo">' + errorPhoto);
        $(this).parents('tr').find('td.author-photo').prepend(inputPhoto);
        var htmlDes = $(this).parents('tr').find('td.author-description').html();
        var inputDes = $('<input class="form-control" type="text" name="description" value="">' + errorDescription);
        inputDes.val(htmlDes);
        $(this).parents('tr').find('td.author-description').html(inputDes);

        $(this).html('<i class="fa fa-pencil"></i>&nbsp;Update');
        $(this).removeClass('edit-author').addClass('update-author');
    });

    $('#author').on('click', '.update-author', function () {
        var item = $(this);
        var authorId = $(this).parents('tr').data('id');
        var description = $(this).parents('tr').find('input[name="description"]').val();
        var name = $(this).parents('tr').find('input[name="name"]').val();
        var photo = $(this).parents('tr').find('input[name="photo"]')[0].files[0];
        var formData = new FormData();
        formData.append('description', description);
        formData.append('name', name);
        if (photo !== undefined) {
            formData.append('photo', photo);
        }

        if (authorId) {
            $.ajax({
                url: baseUrl() + '/admin/authors/' + authorId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function success(data) {
                    if (data.message) {
                        $.each(data.message, function (key, value) {
                            $('.error-table-' + key).text(value);
                        });
                    } else {
                        swal({
                            title: labelUpdateSuccess,
                            text: "",
                            type: "success"
                        });
                        renderTable(keyword, limit, sortBy, page, tab);
                    }
                }
            });
        }
    });

    $('#author').on('click', '#search-author', function () {
        keyword = $(this).parents('.form-search').find('input[name="keyword"]').val();
        renderTable(keyword, limit, sortBy, page, tab);
    });

    $('#author').on('change', '#show-item', function () {
        limit = $(this).val();
        renderTable(keyword, limit, sortBy, page, tab);
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

        $('#author').on('click', '.sort', function () {
        var el = $(this);
        var sortName = el.data('sort-name');

        if (el.hasClass(sortAscClass)) {
            changeSort(el, sortAscClass, sortDescClass, sortName);
        } else {
            changeSort(el, sortDescClass, sortAscClass, sortName);
        }
        renderTable(keyword, limit, inputSortBy.val(), page, tab);
    });

    $('#author').on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        renderTable(keyword, limit, inputSortBy.val(), page, tab);
    });

    $('#author').on('change', '#photo', function (e) {
        var oldImg = $(this).parents('#author-form').find('#preview-img');
        readUrl($(this), this, oldImg);
    });
    $('#author').on('change', '#photo-table', function (e) {
        var oldImg = $(this).parents('.author-photo').find('img');
        readUrl($(this), this, oldImg);
    });
});

function readUrl(input, element, oldImg) {
    var oldUrl = oldImg.data('url');
    if (element.files && element.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            input.parents('#author-form').find('#preview-section').removeClass('hidden');
            oldImg.attr('src', e.target.result);
        };

        reader.readAsDataURL(element.files[0]);
    } else {
        input.parents('#author-form').find('#preview-section').addClass('hidden');
        oldImg.attr('src', oldUrl);
    }
}