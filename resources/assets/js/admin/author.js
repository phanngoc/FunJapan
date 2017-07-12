$(document).ready(function () {
    var keyword;
    var sortBy;
    var page;
    var tab = 'author';
    $('#author').on('click', '#create-author', function () {
        var item = $(this);
        item.prop('disabled', true);
        var url = $(this).data('url');
        var formData = new FormData($('#author-form')[0]);
        var action = $('.action:has(.edit-author)').html();
        $('.error-name').text('');
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
                        $('.error-author-' + key).text(value);
                        item.parents('#author-form').find('input[name="name"]').focus();
                    });
                    $(window).scrollTop(0);
                } else {
                    swal({
                        title: labelCreateSuccess,
                        text: "",
                        type: "success"
                    });
                    $('input').val('');
                    $('#author-form').find('p').text('');
                    renderTable(keyword = null, sortBy = 'id.desc', page = 1, tab);
                    $('#preview-section').hide();
                }

                item.prop('disabled', false);
            }
        });
    });

    var errorName = '<p class="error-table-name text-danger font-bold"></p>';
    var errorPhoto = '<p class="error-table-photo text-danger font-bold"></p>';
    var errorDescription = '<p class="error-table-description text-danger font-bold"></p>';

    $('#author').on('click', '.edit-author', function () {
        var htmlName = $(this).parents('tr').find('td.author-name').text();
        var inputName = $('<input class="form-control" type="text" name="name" value="">' + errorName);
        inputName.val(htmlName);
        $(this).parents('tr').find('td.author-name').html(inputName);
        var htmlPhoto = $(this).parents('tr').find('td img').attr('src');
        var inputPhoto = $('<input type="file" accept="image/jpeg,image/png,image/jpg" id="photo-table" name="photo">' + errorPhoto);
        $(this).parents('tr').find('td.author-photo').prepend(inputPhoto);
        var htmlDes = $(this).parents('tr').find('td.author-description').text();
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
                            item.parents('tr').find('.error-table-' + key).text(value);
                            item.parents('tr').find('input[name="name"]').focus();
                        });
                    } else {
                        swal({
                            title: labelUpdateSuccess,
                            text: "",
                            type: "success"
                        });
                        renderTable(keyword, sortBy, page, tab);
                    }
                }
            });
        }
    });

    $('#author').on('click', '#search-author', function () {
        keyword = $(this).parents('.form-search').find('input[name="keyword"]').val();
        renderTable(keyword, sortBy, page, tab);
    });

    var inputSortBy = $('#author').find('input[name="sortBy"]');
    var sortAscClass = 'sort-asc';
    var sortDescClass = 'sort-desc';

    var inputSortByVal = inputSortBy.val().split('.');

    $('#author').find('.sort').each(function (index) {
        var el = $(this);
        var sortName = el.data('sort-name');

        if (inputSortByVal && inputSortByVal[0] == sortName) {
            el.addClass('sort-' + inputSortByVal[1]);
        }
    });

    $('#author').on('click', '.sort', function () {
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

        renderTable(keyword, inputSortBy.val(), page, tab);
    });

    $('#author').on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        renderTable(keyword, inputSortBy.val(), page, tab);
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
        var ext = element.value.split('.').pop().toLowerCase();
        var mimes = $('#image-mimes').data('mimes').split(",");
        var mess = $('#image-mimes').data('message');
        var messSize = $('#image-mimes').data('message-size');
        var maxSize = $('#image-mimes').data('max-size');
        if ($.inArray(ext, mimes) == -1) {
            element.value = '';
            swal("Cancelled", mess, "error");
            input.parents('#author-form').find('#preview-section').hide();
            input.parents('.author-photo').find('#preview').hide();
        } else {
            var size = element.files[0].size;
            if (size / 1024 > maxSize) {
                element.value = '';
                swal("Cancelled", messSize, "error");
                input.parents('#author-form').find('#preview-section').hide();
                input.parents('.author-photo').find('#preview').hide();
            } else {
                reader.onload = function (e) {
                    oldImg.attr('src', e.target.result);
                };
                reader.readAsDataURL(element.files[0]);
                input.parents('#author-form').find('#preview-section').show();
                input.parents('.author-photo').find('#preview').show();
            }
        }
    } else {
        input.parents('#author-form').find('#preview-section').hide();
        input.parents('.author-photo').find('#preview').show();
        oldImg.attr('src', oldUrl);
    }
}
