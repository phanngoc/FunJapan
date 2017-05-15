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
});
