$(document).ready(function (e) {

    $('.datetime-picker').datetimepicker({
            format: 'Y-m-d H:i'
    });

    var tableOmikuji = $('#omikuji-table').DataTable({
        'processing': true,
        'serverSide': true,
        'searchDelay': 400,
        'aaSorting': [[ 6, 'desc' ]],
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
            { 'data': 'created_at' },
            { 'data': 'status' },
        ],
        'columnDefs': [{
            'targets': [0,2],
            'sortable': false,
            'class': 'text-center',
        },
        {
            'targets': [3,4,5,6],
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
            $('td', row).eq(1).empty().append('<a href="' + detailLink + '">' + encodeHTML(data.name) + '</a>');
            $('td', row).eq(2).empty().append('<img src="' + data.imageUrl + '">');
            $('td', row).eq(3).empty().append(data.start_time);
            $('td', row).eq(4).empty().append(data.end_time);
            $('td', row).eq(5).empty().append(data.recover_time);
            $('td', row).eq(6).empty().append(data.created_at);
            $('td', row).eq(7).empty().append(data.status);
            $('td', row).eq(8).empty().append('<div class="text-center"><a href="' + data.urlEdit + '" class="edit" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa fa-lg"></i></a>'
                + ' <a href="#" data-url="'+ data.url +'" data-confirm="'+ encodeHTML(data.confirm) +'" class="deleteOmikuji" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o fa fa-lg"></i></a></div>');
        },
    });

    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "percent-pre": function ( a ) {
            return parseFloat( a );
        },

        "percent-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "percent-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    } );

    var detailTableOmikuji  = $('#detail-omikuji-table').DataTable({
        paging: true,
        order: [],
        searching: false,
        "aoColumnDefs": [
            {
                "sType": "percent",
                "aTargets": [ 2 ]
            },
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
        addRowEditForm();
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
            '&nbsp; <img id="image-item-preview-'+ countTable +'" class="item-hide" src="" width="32" height="32"  title="Preview Image"></td>' +
            '<td class="text-center"><a href="javascript:void(0)" class="delete-new-row" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o fa fa-lg"></i></a><input name="omikujiItem_id[' + countTable + ']" type="hidden" value=""></td>' +
            '</tr>');
        focusScroll();
        checkRow();
    }

    function focusScroll(){
        $("html, body").animate({ scrollTop: $(document).height() }, 400);
        $('.table input[type=text][name^=item]:last')[0].focus();
    }

    $('.select-locale').on('change', function (e) {
        $('.omikuji-list').submit();
    });

    $(".add-row-create-form").click(function(){
        addRowCreateForm();
        $('#statusForm').data('status','change');
    });

    $(".add-row-edit-form").click(function(){
        addRowEditForm();
        $('#statusForm').data('status','change');
    });

    $( 'body' ).on( 'click', '.delete-new-row', function (e) {
        if (checkRow()) {
            var confirm = $('#delMessage').data('msg');
            var check = false;
            $(this).closest('tr').find('input').each (function() {
                if ($(this).val()) {
                    check = true;
                }
            });
            if (check) {
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
                        reDrawTable();
                    });
            } else {
                $(e.target).closest('tr').remove();
                reDrawTable();
            }
            checkRow();
        }
    });

    function reDrawTable() {
        $('#omikuji-item-table tbody tr').each(function(index) {
            $(this).find('td:nth-child(1)').html(index+1);
            $(this).find('td:nth-child(2) input').attr('name','item[' + (index + 1) +']');
            $(this).find('td:nth-child(3) input').attr('name','rate_weight[' + (index + 1) +']');
            $(this).find('td:nth-child(4) input').attr('name','point[' + (index + 1) +']');
            $(this).find('td:nth-child(5) input').attr('name','item_image[' + (index + 1) +']');
            $(this).find('td:nth-child(5) img').attr('id','image-item-preview-' + (index + 1));
            $(this).find('td:nth-child(6) input').attr('name','omikujiItem_id[' + (index + 1) +']');
        });
    }

    function checkRow() {
        var count = 0;
        $('#omikuji-item-table tbody tr').each(function(index) {
            count++;
        });
        if (count == 1) {
            $('#omikuji-item-table tbody tr td:last a').addClass('cursor-not-allowed');
            return false;
        }
        $('#omikuji-item-table tbody tr td a').removeClass('cursor-not-allowed');
        return true;
    }

    checkRow();

    $( 'body' ).on('change', 'input,select', function (e) {
        $('#statusForm').data('status','change');
    });

    $(".delete-omikuji-item").click(function(){
        if (checkRow()) {
            var action = $(this).data('url');
            var confirm = $(this).data('confirm');
            var id = $(this).closest('td').find('input[name^=omikujiItem_id]').val();
            var element = $(this).closest('tr');
            swal({
                title: confirm,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: true
            },
            function(){
                element.remove();
                $('#deleteList').val(addString($('#deleteList').val(), id));
                reDrawTable();
                checkRow();
            });
        }
    });

    function addString(str1, str2) {
        if (str1 == null || str1 == '') {
            return str2;
        }

        return str1 + ',' + str2;
    }

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
        var str = $(this).attr('name');
        var start = str.indexOf("[");
        var end = str.indexOf("]");
        var index = str.substring(start+1,end);
        readURL(e.target,'omikuji-item', index);
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
