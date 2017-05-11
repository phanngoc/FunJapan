$(document).ready(function (e) {

    $('.datetime-picker').datetimepicker({
            format: 'Y-m-d H:i'
    });

    var tableOmikuji = $('#omikuji-table').DataTable({
        'processing': true,
        'serverSide': true,
        'searchDelay': 400,
        'aaSorting': [[ 1, 'desc' ]],
        "language": {
            "infoFiltered": ''
        },
        'ajax': {
            'url': $('#omikuji-table').data('url'),
            'type': 'GET',
        },
        'columns': [
            { 'data': 'id' },
            { 'data': 'name' },
            { 'data': 'image' },
            { 'data': 'start_time' },
            { 'data': 'end_time' },
            { 'data': 'recover_time' },
            { 'data': 'locale_id' },
            { 'data': 'status' },
        ],
        'columnDefs': [{
            'targets': [0,2],
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': [3,4,5],
            'class': 'text-center',
        },
        {
            'targets': 8,
            'sortable': false,
            'searchable': false,
            'data': function () {
                return '';
            }
        }],

        'createdRow': function (row, data, index) {
            var pageInfo = tableOmikuji.page.info();
            $('td', row).eq(0).empty().append(pageInfo.page * pageInfo.length + index + 1);
            var detailLink = baseUrl() + '/admin/omikujis/' + data.id ;
            $('td', row).eq(1).empty().append('<a href="' + detailLink + '">' + data.name + '</a>');
            $('td', row).eq(2).empty().append('<img src="' + data.imageUrl + '">');
            $('td', row).eq(6).empty().append(locales[data.locale_id]);
            $('td', row).eq(3).empty().append(data.start_time);
            $('td', row).eq(4).empty().append(data.end_time);
            $('td', row).eq(5).empty().append(data.recover_time);
            $('td', row).eq(7).empty().append(data.status);
            $('td', row).eq(8).empty().append('<div class="text-center"><a href="' + data.urlEdit + '" class="edit" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa fa-lg"></i></a>'
                + ' <a href="#" data-url="'+ data.url +'" data-confirm="'+ data.confirm +'" class="deleteOmikuji" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o fa fa-lg"></i></a></div>');
        },
    });



    var detailTableOmikuji  = $('#detail-omikuji-table').DataTable({
        paging: true,
        order: [],
        searching: false,
        "columnDefs": [
        {
            "orderable": false,
            "targets": [0,4]
        }
        ],
    });

    detailTableOmikuji.on( 'order.dt search.dt', function () {
        detailTableOmikuji.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    function addRowCreateForm() {
        var countTable =$('#omikuji-item-table tr').length;
        $('#omikuji-item-table').append(
            '<tr>' +
            '<td class="text-center">' + (countTable ) + '</td>' +
            '<td><input class="form-control " name="item[' + (countTable ) + ']" type="text" ></td>' +
            '<td><input class="form-control " name="rate_weight[' + (countTable ) + ']" type="text" ></td>' +
            '<td><input class="form-control " name="point[' + (countTable ) + ']" type="text" ></td>' +
            '<td><input class="mt5 upload-image-item" name="item_image[' + (countTable ) + ']" type="file"  data-index="' + (countTable ) + '"> '+
            '<img id="image-item-preview-'+ (countTable ) +'" class="item-hide" src="" width="32" height="32"  title="Preview Image"></td>' +
            '</tr>');
    }

    function addRowEditForm() {
        var countTable =$('#omikuji-item-table tr').length;
        $('#omikuji-item-table').append(
            '<tr>' +
            '<td class="text-center">' + countTable  + '</td>' +
            '<td><input class="form-control " name="item[' + countTable  + ']" type="text" ></td>' +
            '<td><input class="form-control " name="rate_weight[' + countTable  + ']" type="text" ></td>' +
            '<td><input class="form-control " name="point[' + countTable + ']" type="text" ></td>' +
            '<td><input class="mt5 upload-image-item" name="item_image[' + countTable + ']" type="file"  data-index="' + countTable + '"> '+
            '<img id="image-item-preview-'+ countTable +'" class="item-hide" src="" width="32" height="32"  title="Preview Image"></td>' +
            '<td class="text-center"><a href="#" class="delete-new-row" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o fa fa-lg"></i></a><input name="omikujiItem_id[' + countTable + ']" type="hidden" value=""></td>' +
            '</tr>');
    }

    $(".add-row-create-form").click(function(){
        addRowCreateForm();
    });

    $(".add-row-edit-form").click(function(){
        addRowEditForm();
    });

    $( 'body' ).on( 'click', '.delete-new-row', function (e) {
        //var confirm = $(this).data('confirm');
        var confirm = 'Are you want to delete it';
        swal({
            title: confirm,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            closeOnConfirm: true
        },
        function(){
            $(e.target).closest('tr').remove();
            $('#omikuji-item-table tbody tr').each(function(index) {
                console.log(index);
                $(this).find('td:nth-child(1)').html(index+1);
                $(this).find('td:nth-child(2) input').attr('name','item[' + (index + 1) +']');
                $(this).find('td:nth-child(3) input').attr('name','rate_weight[' + (index + 1) +']');
                $(this).find('td:nth-child(4) input').attr('name','point[' + (index + 1) +']');
                $(this).find('td:nth-child(5) input').attr('name','item_image[' + (index + 1) +']');
                $(this).find('td:nth-child(5) img').attr('id','image-item-preview-' + (index + 1));
                $(this).find('td:nth-child(6) input').attr('name','omikujiItem_id[' + (index + 1) +']');

            });
        });
    });

    $('input,select').change(function() {
        $('#statusForm').data('status','change');
    });

    $(".delete-omikuji-item").click(function(){
        var action = $(this).data('url');
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
            $('#delete-omikuji-item-form').attr('action', action).submit();
        });
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

    $( 'body' ).on( 'click', '.deleteOmikuji', function () {
        var action = $(this).data('url');
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
            $('#delete-omikuji-form').attr('action', action).submit();
        });
    });

    function readURL(input, obj, index) {
        if(obj == 'omikuji') {
            imageClick(input, 'imageMimes', 'image-preview');
        } else {
            imageClick(input, 'imageItemMimes', 'image-item-preview-', index);
        }
    }

    $("#upload-image").change(function() {
        readURL(this, 'omikuji', $(this).data('index'));
    });

    $( 'body' ).on( 'change', '.upload-image-item', function (e) {
        readURL(e.target,'omikuji-item', $(this).data('index'));
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

});
