﻿$(function () {
    $('div.article-body').find("iframe[src*='youtube.com']").wrap(function () {
        if (!$(this.parentNode).hasClass('youtube-responsive'))
            return '<p class="youtube-responsive" />';
    });

    $('div.article-body').find("iframe[src*='google.com/maps/']").wrap(function () {
        if (!$(this.parentNode).hasClass('googlemaps-responsive'))
            return '<p class="googlemaps-responsive" />';
    });
});
