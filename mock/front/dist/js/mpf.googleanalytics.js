(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date(); a = s.createElement(o),
    m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

(function () {
    var host = location.host.toLowerCase();

    var trackingId = 'UA-48367933-1'; // インドネシア&タイ用トラッキングID

    if (host.indexOf('malaysia.') === 0)
        trackingId = 'UA-48367933-2'; // マレーシア用トラッキングID

    if (host.indexOf('taiwan.') === 0)
        trackingId = 'UA-48367933-3'; // 台湾用トラッキングID

    ga('create', trackingId, 'auto');
    ga('require', 'displayfeatures');
})();

function trackPageview(isMember, idp, gender, age, visitJapan, isRegisterdVisitor) {
    ga('send', 'pageview', {
        'dimension1': isMember ? 'member' : '(not set)',
        'dimension4': idp ? idp.toLowerCase() : '(not set)',
        'dimension2': gender ? gender.toLowerCase() : '(not set)',
        'dimension3': age ? age.toLowerCase() : '(not set)',
        'dimension5': visitJapan ? visitJapan : '(not set)',
        'dimension6': isRegisterdVisitor ? 'member' : '(not set)'

    });
}
