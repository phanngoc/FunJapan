$(document).ready(function (e) {

    function encodeHTML(s) {
        return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
    }

    $('#description').markdown({
        autofocus:false,
        savable:false
    });

    $('.datetime-picker').datetimepicker({
        format: 'Y-m-d H:i'
    });

    var couponTable = $('#coupon-table').DataTable({
        'processing': true,
        'serverSide': true,
        aLengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        paging: true,
        order: [[ 2, 'desc' ]],
        'language': {
            'infoFiltered' : ''
        },
        'ajax': {
            'url': $('#coupon-table').data('url'),
            'type': 'GET',
        },
        'columns': [
            { 'data': 'id' },
            { 'data': 'name' },
            { 'data': 'can_get_from' },
            { 'data': 'can_get_to' },
            { 'data': 'max_coupon' },
            { 'data': 'required_point' },
            { 'data': 'status' },
        ],
        'columnDefs': [{
            'targets': 0,
            'sortable': false,
            'searchable': false
        },
        {
            'targets': 7,
            'sortable': false,
            'searchable': false,
             'data': function () {
                return '';
            }
        }],
        'createdRow': function (row, data, index) {
            var pageInfo = $('#coupon-table').DataTable().page.info();
            $('td', row).eq(0).empty().append(pageInfo.page * pageInfo.length + index + 1);
            var detailLink = baseUrl() + '/admin/coupons/' + data.id ;

            $('td', row).eq(1).empty().append('<a href="' + detailLink + '">' + encodeHTML(data.name) + '</a>');
            $('td', row).eq(2).empty().append(data.can_get_from);
            $('td', row).eq(3).empty().append(data.can_get_to);
            $('td', row).eq(4).empty().append(commaSeparateNumber(data.max_coupon));
            $('td', row).eq(5).empty().append(commaSeparateNumber(data.required_point));
            $('td', row).eq(6).empty().append(data.status);

            var urlEdit = baseUrl() + '/admin/coupons/' + data.id + '/edit';
            var urlDelete = baseUrl() + '/admin/coupons/' + data.id;

            $('td', row).eq(7).empty().append(' \
                <a href="' + urlEdit + '" class="edit" data-placement="left" data-toggle="tooltip" title="Edit"> \
                    <i class="fa fa-pencil-square-o fa-lg"></i> \
                </a> \
                <a href="#" data-url="' + urlDelete + '" data-confirm="' + encodeHTML(data.confirmDeleteMessage) + '" class="delete" data-toggle="tooltip" \
                    data-placement="top" title="Delete"> \
                    &nbsp;<i class="fa fa-trash-o fa-lg"></i> \
                </a> \
            ');
        },
        'fnDrawCallback': function (data, type, full, meta) {
            $('[data-toggle="tooltip"]').tooltip();
        },
    });

    couponTable.on('order.dt search.dt', function () {
        couponTable.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i+1;
        });
    }).draw();

    $("#image").change(function() {
        imageClick(this, 'image-preview');
    });

    function imageClick(input, idImagePreview) {
        var imagePreview = $('#'+ idImagePreview);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var ext = 'image/' + input.value.split('.').pop().toLowerCase();

            if ($.inArray(ext, dataMimes.split(',')) == -1) {
                swal("Cancelled", dataMessageMineError, "error");
            } else {
                var size = input.files[0].size;
                if ((size/1024) > dataMaxSize) {
                    input.value = '';
                    swal("Cancelled", dataMessageSizeError, "error");
                    imagePreview.hide();
                } else {
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

    $('#coupon-table').on('click', '.delete', function() {
        var url = $(this).data('url');
        var token = $('meta[name="csrf-token"]').attr('content');
        var confirm = $(this).data('confirm');
        var urlReload = baseUrl() + '/admin/coupons';

        swal({
            title: confirm,
            type: "warning",
            html:true,
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
                success: function (response) {
                    window.location.href = urlReload;
                },
                error: function (e) {
                    console.log('error', e);
                    window.location.href = urlReload;
                }
            });
        });
    });

    function getHasChanges() {
        var hasChanges = false;

        $('.ibox').find(":input:not(:button):not([type=hidden])").each(function () {
            if ((this.type == "text" || this.type == "textarea" || this.type == "hidden") && this.defaultValue != this.value) {
                hasChanges = true;
                return false;
            } else {
                if ((this.type == "radio" || this.type == "checkbox") && this.defaultChecked != this.checked) {
                    hasChanges = true;
                    return false;
                } else {
                    if ((this.type == "select-one" || this.type == "select-multiple")) {
                        for (var x = 0; x < this.length; x++) {
                            if (this.options[x].selected != this.options[x].defaultSelected) {
                                hasChanges = true;
                                return false;
                            }
                        }
                    }
                }
            }
        });

        return hasChanges;
    }

    $("#btn-cancel").click(function(){
        var status = getHasChanges();
        var action = $(this).data('url');
        if (status){
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
});
