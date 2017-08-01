var isSearch = false;
$(document).ready(function (e) {
    var table = $('#tag-table').DataTable({
        'order': [[ 3, "desc" ]],
        'processing': true,
        'serverSide': true,
        'searchDelay': 400,
        "language": {
            "infoFiltered": ''
        },
        'ajax': {
            'url': $('#tag-table').data('url'),
            'type': 'GET',
        },
        'columns': [
            { 'data': 'id' },
            { 'data': 'name' },
            { 'data': 'status' },
            { 'data': 'created_at' },
        ],
        'columnDefs': [{
            'targets': 0,
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': 3,
            'class': 'text-center',
        },
        {
            'targets': 4,
            'sortable': false,
            'class': 'text-center',
            'data': function () {
                return '';
            }
        }],
        'createdRow': function (row, data, index) {
            var pageInfo = table.page.info();
            $('td', row).eq(0).empty().append(pageInfo.page * pageInfo.length + index + 1);
            editLink = baseUrl() + '/admin/tags/' + data.id + '/edit';
            blockAction = baseUrl() + '/admin/tagBlock/' + data.id;
            var appendText = '';
            if (data.status == 0) {
                $('td', row).eq(2).empty().append('<span>' + $('#tag-not-block').data('message') + '</span>').addClass('status');

                appendText = '<a data-toggle="tooltip" data-placement="right" title="'
                    + $('#button-block').data('message')
                    + '" href="#"><i data-url="'
                    + blockAction
                    + '" class="fa fa-ban fa fa-lg ban"></i></a>';
            } else {
                $('td', row).eq(2).empty().append('<span>' + $('#tag-block').data('message') + '</span>').addClass('status');

                appendText ='<a data-toggle="tooltip" data-placement="right" title="'
                    + $('#button-unblock').data('message')
                    + '" href="#"><i data-url="'
                    + blockAction
                    + '" class="fa fa-undo fa fa-lg unBan"></i></a>';
            }
            $('td', row).eq(1).empty().append('<a href="' + baseUrl() + '/admin/tags/' + data.id + '">' + encodeHTML(data.name) + '</a>');
            $('td', row).eq(4).empty().append('<a data-toggle="tooltip" data-placement="left" title="'
                + $('#button-edit').data('message')
                +'" href="'
                + editLink
                + '" class="edit"><i class="fa fa-pencil-square-o fa fa-lg"></i></a>'
                + '<a data-toggle="tooltip" data-placement="top" title="'
                + $('#button-delete').data('message')
                +'" href="#" class="delete"><i data-id="'
                + data.id
                + '" class="fa fa-trash fa fa-lg"></i></a>'
                + appendText);
        },
        'fnDrawCallback': function (data, type, full, meta) {
            $('[data-toggle="tooltip"]').tooltip();
        },
    });

    $(document).on('click', '.ban', function (e) {
        blockAction = $(e.target).data('url');
        swal({
            title: $('#block-confirm').data('message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url: blockAction,
                type: 'POST',
            })
            .done(function(response) {
                if (response.status == 1) {
                    $(e.target).removeClass('ban');
                    $(e.target).removeClass('fa-ban');
                    $(e.target).addClass('unBan');
                    $(e.target).addClass('fa-undo');
                    $(e.target).parent().attr('data-original-title', $('#button-unblock').data('message'));
                    $(e.target).parent().parent().siblings('.status').empty().append('<span>' + $('#tag-block').data('message') + '</span>');
                    swal.close();
                } else {
                    swal($('#button-error').data('message'));
                }
            })
            .fail(function() {
            })
        });
    });

    $(document).on('click', '.unBan', function (e) {
        blockAction = $(e.target).data('url');
        swal({
            title: $('#un-block-confirm').data('message'),
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                url: blockAction,
                type: 'POST',
            })
            .done(function(response) {
                if (response.status == 1) {
                    $(e.target).removeClass('unBan');
                    $(e.target).removeClass('fa-undo');
                    $(e.target).addClass('ban');
                    $(e.target).addClass('fa-ban');
                    $(e.target).parent().attr('data-original-title', $('#button-block').data('message'));
                    $(e.target).parent().parent().siblings('.status').empty().append('<span>' + $('#tag-not-block').data('message') + '</span>');
                    swal.close();
                } else {
                    swal($('#button-error').data('message'));
                }
            })
            .fail(function() {
            })
        });
    });

    //new spec
    $('#create').on('click', function(e) {
        e.preventDefault();
        clearNotification();
        var data = $('#tag-create-form').serialize();
        var url = $('#tag-create-form').attr('action');
        $('#clear').addClass('hidden');
        isSearch = false;
        $('#search-input').val('');
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
        })
        .done(function(response) {
            if (response.status == 0) {
                showMessage(response.message, 'danger');
            } else if (response.status == 1) {
                showMessage(response.message, 'success');
                $('#tag-create-form')[0].reset();
                loadData(tagLoadUrl + '?query=&page=1');
            } else {
                showValidate(response);
            }
        });
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        clearNotification();
        var url = $(this).attr('href');
        loadData(url);
    });

    $(document).on('click', '.edit', function(e) {
        var id = $(this).data('id');
        var editItem;
        clearNotification();
        $.each(dataTags.data, function(index, val) {
            if (val.id == id) {
                editItem = val;

                return false;
            }
        });
        $('#form-edit #name').val(editItem.name);
        $('#form-edit input[name=\'id\']').val(id);
        $.each(editItem.tag_locales, function(index, val) {
            $('#form-edit #name' + val.locale_id).val(val.name);
        });
        $('#edit-' + id).empty().append($('#form-edit').clone()).removeClass('text-center');
    });

    $(document).on('click', '.cancel', function(e) {
        e.preventDefault();
        if (isSearch) {
            loadData(tagLoadUrl + '?search=1&query=' + $('#search-input').val() + '&page=' + dataTags.current_page);
        } else {
            loadData(tagLoadUrl + '?query=&page=' + dataTags.current_page);
        }
    });

    $(document).on('click', '.update', function(e) {
        e.preventDefault();
        clearNotification();
        var data = $(this).parent().parent().parent('form').serialize();
        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
        })
        .done(function(response) {
            if (response.status == 0) {
                showMessage(response.message, 'danger');
            } else if (response.status == 1) {
                showMessage(response.message, 'success');
                $('#tag-create-form')[0].reset();
                if (isSearch) {
                    loadData(tagLoadUrl + '?search=1&query=' + $('#search-input').val() + '&page=' + dataTags.current_page);
                } else {
                    loadData(tagLoadUrl + '?query=&page=' + dataTags.current_page);
                }
            } else {
                showValidate(response);
            }
            scrollTo();
        })
    });

     $(document).on('click', '.delete', function (e) {
        clearNotification();
        var url = $(this).data('url');
        var id = $(this).data('id');
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
            $.ajax({
                url: url,
                type: 'POST',
                data: {id: id},
            })
            .done(function(response) {
                if (response.status == 0) {
                    showMessage(response.message, 'danger');
                } else if (response.status == 1) {
                    showMessage(response.message, 'success');
                    $('#tag-create-form')[0].reset();
                    if (dataTags.from == dataTags.to) {
                        if (isSearch) {
                            loadData(tagLoadUrl + '?search=1&query=' + $('#search-input').val() + '&page=' + (dataTags.current_page - 1));
                        } else {
                            loadData(tagLoadUrl + '?query=&page=' + (dataTags.current_page - 1));
                        }
                    } else {
                        if (isSearch) {
                            loadData(tagLoadUrl + '?search=1&query=' + $('#search-input').val() + '&page=' + dataTags.current_page);
                        } else {
                            loadData(tagLoadUrl + '?query=&page=' + dataTags.current_page);
                        }
                    }
                }
                scrollTo();
                swal.close();
            })
        });
    });

    $('#search').on('click', function(e) {
        e.preventDefault();
        clearNotification();
        var searchInput = $('#search-input').val();
        if ($.trim(searchInput) == '') {
            swal('Pls enter keyword', null,'warning');
        } else {
            isSearch = true;
            $('#clear').removeClass('hidden');
            loadData(tagLoadUrl + '?search=1&page=1&query=' + searchInput);
        }
    })

    $('#search-form input').on('keypress', function(e) {
        return e.which !== 13;
    });

    $('#clear').on('click', function(e) {
        e.preventDefault();
        clearNotification();
        $(this).addClass('hidden');
        isSearch = false;
        $('#search-input').val('');
        loadData(tagLoadUrl + '?page=1&query=');
    })
})

function scrollTo() {
    $('html, body').animate(
        {
            scrollTop: $('body').offset().top
        },
        1000
    );
}

function clearNotification() {
    $('#notification').empty();
}

function showMessage(message, message_class) {
    var insertText = '<div class="alert mt20 alert-' + message_class + '" id="alert-message">'
        + '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
        +   '<span aria-hidden="true">×</span>'
        + '</button>'
        + '<p>' + message + '</p></div>';
    $('#notification').append(insertText);
}

function showValidate(data) {
    var insertText = '<div class="alert mt20 alert-danger" id="alert-message">'
        + '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
        +   '<span aria-hidden="true">×</span>'
        + '</button>';
        $.each(data, function(index, val) {
        var name = index.replace('name', '');
        insertText += '<p>' + val[0].replace(index, locales[name] + ' Tag Name') + '</p>';
    });
    insertText += '</div>';
    $('#notification').append(insertText);
}

function loadData(url) {
    $.get(url, function(data) {
        $('#tag-list').empty().append(data);
    });
}
