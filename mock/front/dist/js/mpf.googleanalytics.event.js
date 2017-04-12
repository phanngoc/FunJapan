// YouTube APIをロードする。
var tag = document.createElement('script');
tag.src = "//www.youtube.com/iframe_api";
tag.async = true;
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// YouTube APIがロードされるとコールバックされる。
function onYouTubeIframeAPIReady() {
    $('iframe').each(function () {
        var iframe = this;

        // YouTube動画にトラッキングを仕込む
        if (!/youtube\.com\/embed/.test(iframe.src))
            return;

        // Javascript APIを有効にする
        if (iframe.src.indexOf('enablejsapi=') === -1)
            iframe.src += (iframe.src.indexOf('?') === -1 ? '?' : '&') + 'enablejsapi=1';

        iframe.ytplayer = new YT.Player(iframe, {
            events: {
                onStateChange: onYouTubePlayerStateChange
            }
        });
    });
}

function onYouTubePlayerStateChange(e) {
    var eventLabel = e.target.getVideoUrl();

    // PLAYING状態への遷移が動画の始め3秒以内の場合のみ再生回数を記録する。
    if (e.data == YT.PlayerState.PLAYING && e.target.getCurrentTime() <= 3)
        ga('send', 'event', 'video-youtube', 'play', eventLabel);
    else if (e.data == YT.PlayerState.ENDED)
        ga('send', 'event', 'video-youtube', 'end', eventLabel);
}

function eventTracker(category, action, label, hitCallback, nonInteraction) {
    ga('send', 'event', category, action, label, { 'hitCallback': hitCallback, 'nonInteraction': nonInteraction });
};

function setClickTracking(event) {
    // クリックトラッキングを仕込む
    var element = $(event.currentTarget);
    var href = element.attr('href');
    var data = element.data('gaevent-clicked');
    var isTargetBlank = element.attr('target') == '_blank';

    if (isTargetBlank) {
        eventTracker(data.category, data.action, data.label ? data.label : href, null);
        return true;
    };

    eventTracker(data.category, data.action, data.label ? data.label : href, function () { document.location = href; });
    return false;
};


function setClickTrackingExternalLink(event) {
    // クリックトラッキング情報が指定されていない場合、外部へのリンクのみトラックするように仕込む
    var element = $(event.currentTarget);
    var href = element.attr('href');
    var isTargetBlank = element.attr('target') == '_blank';
    var domain = (href.match(/(^https?:\/\/)([^/]+)/i) || [])[2] || null;

    if (domain != null && domain != location.host) {
        eventTracker('outbound', 'click', href, function () { if (!isTargetBlank) document.location = href; });
        return isTargetBlank;
    };
};

function setImpressionTracking(e) {
    // インプレッショントラッキングを発射する
    var href = e.attr('href');
    var data = e.data('gaevent-served');

    var isSent = e.attr('data-gaevent-served-issent');

    if (!isSent) {
        eventTracker(data.category, data.action, data.label ? data.label : href, null, true);
        e.attr('data-gaevent-served-issent', 'true');
    };
};



$(function () {

    $('a[data-gaevent-clicked]').on('click.tracking', setClickTracking);
    $('a:not([data-gaevent-clicked])').on('click.tracking.external', setClickTrackingExternalLink);

    $('a[data-gaevent-served]').each(function () { setImpressionTracking($(this)) });
});