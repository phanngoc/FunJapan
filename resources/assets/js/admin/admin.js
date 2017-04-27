baseUrl = function () {
    return window.location.protocol + '//' + window.location.host;
};

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
