$(document).ready(function (e) {
    $("#image").change(function() {
        imageClick(this, 'imageMimes', 'image-preview');
    });

    function imageClick(input, idImageInfor, idImagePreview, index='') {
        var imagePreview = $('#'+ idImagePreview + index);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var ext = input.value.split('.').pop().toLowerCase();
            var mimes = $('#' + idImageInfor).data('mimes').split(",");
            var mess = $('#' + idImageInfor).data('message');
            var messSize = $('#' + idImageInfor).data('message-size');
            var maxSize = $('#' + idImageInfor).data('max-size');
            if ($.inArray(ext, mimes) == -1){
                input.value = '';
                imagePreview.hide();
                swal("Cancelled", mess, "error");
            } else {
                var size = (input.files[0].size);
                if ((size/1024) > maxSize){
                    input.value = '';
                    swal("Cancelled", messSize, "error");
                    imagePreview.hide();
                }else{
                    reader.onload = function(e) {
                        imagePreview.attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                    imagePreview.show();
                }
            }
        } else {
            imagePreview.hide();
        }
    }

    $('.delete').click(function() {
        var url = $(this).data('url');
        var token = $('meta[name="csrf-token"]').attr('content');
        var urlRedirect = $('#url-redirect').data('url');
        var confirm=$(this).data('confirm')
        swal({
            title: confirm,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                headers: { 'X-CSRF-TOKEN' : token },
                type: 'DELETE',
                url: url,
                data: {},
                success: function (response) {
                    window.location.href = urlRedirect;
                },
                error: function (e) {
                    window.location.href = urlRedirect;
                }
            });
        });
    });

    var categoryTable = $('#category-table').DataTable( {
        aLengthMenu: [[10, 25, 50], [10, 25, 50]],
        paging: true,
        order: [[ 4, 'desc' ]],
        'columnDefs': [{
            'targets': [0,3],
            'sortable': false,
            'searchable': false
        },
        {
            'targets': 5,
            'sortable': false,
            'searchable': false
        }],
        'createdRow': function (row, data, index) {
            var pageInfo = $('#category-table').DataTable().page.info();
            $('td', row).eq(0).empty().append(pageInfo.page * pageInfo.length + index + 1);
        },
    });

    categoryTable.on( 'order.dt search.dt', function () {
        categoryTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $('input,select').change(function() {
        $('#statusForm').data('status','change');
    });

    $(".cancel").click(function(){
        var status = $('#statusForm').data('status');
        var action = $(this).data('url');
        if (status == 'change'){
            var confirm = $(this).data('confirm');
            swal({
                title: confirm,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            },
            function(){
                window.location.href = action;
            });
        } else {
            window.location.href = action;
        }
    });

    $('.select-locale').on('change', function (e) {
        $('#category-list').submit();
    });
});