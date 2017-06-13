$(function () {
    Echo.private('notification.' + channel)
        .listen('NotificationEvent', (e) => {
            $('#notifications').find('.notification-list').prepend(e.html);
            $('#notifications').find('.no-notifications').empty();
            var currentTotal = $('#notifications').find('.badge-number').text();
            currentTotal = currentTotal == '' ? 0 : parseInt(currentTotal);
            $('#notifications').find('.badge-number').empty().append(currentTotal + 1);
            timeDiffHuman();
        });

    $.ajax({
        'url': urlGetNotifications,
        'type': 'GET',
        success: (response) => {
            if (response.success) {
                if (response.total > 0) {
                    $('#notifications').find('.badge-number').empty().append(response.total);
                }

                $('#notifications').append(response.htmlNotifications);
                timeDiffHuman();
            }
        }
    });

    $('#notifications').on('click', function () {
        $.ajax({
            'url': urlDismissNotifications,
            'type': 'GET',
            success: (response) => {
                if (response.success) {
                    $('#notifications').find('.badge-number').empty();
                }
            }
        });
    });

    setInterval(function () {
        timeDiffHuman();
    }, 60000);
});

function timeDiffHuman() {
    $('#notifications').find('.notification').each(function () {
        var thisTime = $(this).find('.time');
        thisTime.find('span').text(moment.tz(thisTime.attr('data-time'), timezone).fromNow());
    });
}
