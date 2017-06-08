$(document).ready(function (e) {
    $('.datetime-picker').datetimepicker({
        format: 'Y-m-d H:i'
    });

    var table = $('#api-token-table').DataTable({
        'order': [[ 0, 'desc' ]],
        'processing': true,
        'searching': false,
        'serverSide': true,
        'searchDelay': 400,
        'language': {
            'infoFiltered': ''
        },
        'ajax': {
            'url': $('#api-token-table').data('url'),
            'type': 'GET',
        },
        'columns': [
            { 'data': 'id' },
            { 'data': 'token' },
            { 'data': 'expired_to' },
            { 'data': 'user.name' },
            { 'data': 'is_active' },
        ],
        'columnDefs': [
            {
                'targets': 0,
                'sortable': false,
                'class': 'text-center',
            },
            {
                'targets': 1,
                'sortable': false,
                'class': 'text-center',
            },
            {
                'targets': 2,
                'class': 'text-center min-width-160',
            },
            {
                'targets': 3,
                'sortable': false,
                'class': 'text-center',
            },
            {
                'targets': 4,
                'sortable': false,
                'class': 'text-center',
            },
            {
                'targets': 5,
                'sortable': false,
                'searchable': false,
                'class': 'text-center',
                'data': function () {
                    return '';
                }
            }],
        'createdRow': function (row, data, index) {
            var pageInfo = table.page.info();
            $('td', row).eq(0).empty().html(pageInfo.page * pageInfo.length + index + 1);
            $('td', row).eq(1).empty().html('<pre class="show-token">' + data.token + '</pre>');
            $('td', row).eq(1).empty().html('<pre class="show-token">' + data.token + '</pre>');

            if (data.is_active) {
                $('td', row).eq(4).empty().html('<button class="btn btn-info btn-circle btn-lg" type="button"><i class="fa fa-check"></i></button>');
            } else {
                $('td', row).eq(4).empty().html('<button class="btn btn-warning btn-circle btn-lg" type="button"><i class="fa fa-times"></i></button>');
            }

            $('td', row).eq(5).empty().html('<button class="btn btn-danger btn-rounded delete-token" data-url="' + baseUrl() + '/admin/setting/api-token/delete/' + data.id + '">Delete</button>');
        }
    });

    $(document).on('click', '.delete-token', function(event){
        var element = $(this);

        swal({
            title: lblConfirmRemove,
            text: lblConfirmRemoveTitle,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: lblButtonYes,
            cancelButtonText: lblButtonNo,
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                window.location.replace(element.data('url'));
            }
        });
    });

    $('#user-choice').select2({
        placeholder: "Select a state",
        allowClear: true,
        ajax: {
            url: baseUrl() + "/admin/setting/api-token/get-user",
            dataType: 'json',
            delay: 250,
            data: function data(params) {
                return {
                    key_word: params.term,
                    page: params.page,
                };
            },
            processResults: function processResults(data, params) {
                params.page = params.page || 1;

                return {
                    results: data.data,
                    pagination: {
                        more: params.page * articleSuggest < data.total
                    }
                };
            },
            cache: true
        },

        escapeMarkup: function escapeMarkup(markup) {
            return markup;
        },
        minimumInputLength: 1,
        minimumResultsForSearch: -1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    $('#user-choice').on("select2:select", function (e) {
        $(this).siblings('input').val(e.params.data.name);
        $(this).siblings('p.text-danger').text('');
    });

    $('#user-choice').on("change", function (e) {
        if (e.currentTarget.value) {
            return;
        }

        $(this).siblings('input').val('');
        $(this).siblings('p.text-danger').text('');
    });

    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        return '<div class="clearfix">' + encodeHTML(repo.name) + '</div>';
    }

    function formatRepoSelection(repo) {
        if (repo.selected) return repo.text;

        var textShow = repo.name || repo.email;

        if (textShow) {
            textShow = encodeHTML(textShow);
        }
        return textShow;
    }
});
