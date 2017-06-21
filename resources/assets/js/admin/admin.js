baseUrl = function () {
    return window.location.protocol + '//' + window.location.host;
};

encodeHTML = function (s) {
    return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
}

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form = $('.filter-sort-form');
    var inputSortBy = form.find('[name="sortBy"]');

    function submitForm() {
        form.submit();
    }

    $('#per-page').change(function() {
        form.find('[name="perPage"]').val($(this).val());
        submitForm();
    });

    if (typeof inputSortBy.val() != 'undefined') {
        sortTable(inputSortBy, '.', submitForm);
    }
});

commaSeparateNumber = function (val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return val;
}

sortTable = function (inputSortBy, sortKeyDirDelimiter, onChangeSort) {
    var sortAscClass = 'sort-asc';
    var sortDescClass = 'sort-desc';

    var inputSortByVal = inputSortBy.val().split(sortKeyDirDelimiter);

    var useDefaultSort = true;
    $('.sortable').each(function (index) {
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
            inputSortBy.val(sortName + sortKeyDirDelimiter + 'asc');
        } else {
            inputSortBy.val(sortName + sortKeyDirDelimiter + 'desc');
        }

        onChangeSort();
    }

    $('.sortable').click(function() {
        var el = $(this);
        var sortName = el.data('sort-name');

        if (el.hasClass(sortAscClass)) {
            changeSort(el, sortAscClass, sortDescClass, sortName);
        } else {
            changeSort(el, sortDescClass, sortAscClass, sortName);
        }
    });
}
