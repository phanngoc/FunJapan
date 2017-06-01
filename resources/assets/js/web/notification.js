$(function () {
    Echo.private('notification.' + channel)
        .listen('NotificationEvent', (e) => {
            $('#notifications').removeClass('open');
            $('#notifications').find('.notifications').removeClass('hidden');
            $('#notifications').find('.notification-list').prepend(e.html);
            var currentTotal = parseInt($('#notifications').find('.badge-number').text());
            $('#notifications').find('.badge-number').empty().append(currentTotal + 1);
        });

    $.ajax({
        'url': urlGetNotifications,
        'type': 'GET',
        success: (response) => {
            if (response.success) {
                $('#notifications').find('.badge-number').empty().append(response.total);
                $('#notifications').append(response.htmlNotifications);
            }
        }
    });

    $('#notifications').on('click', function () {
        $.ajax({
            'url': urlDismissNotifications,
            'type': 'GET',
            success: (response) => {
                if (response.success) {
                    $('#notifications').find('.badge-number').empty().append(0);
                }
            }
        });
    });
});
