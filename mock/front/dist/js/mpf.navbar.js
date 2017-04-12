$(document).ready(function () {
    var caret_ups = $('.caret-up');
    caret_ups.addClass('hidden');
    var tabs = $('.fj-tab');
    
    tabs.click(function (e) {
        var tab = $(this);
        var tab_item = tab.parent('li');
        var caret_up = tab_item.children('.caret-up');

        if (tab_item.hasClass('active')) {
            window.setTimeout(function () {
                tab_item.removeClass('active');
                $('.tab-pane.navbar-tab').removeClass('active');
                caret_up.addClass('hidden');
            }, 1);
            tab.children('i.fa').attr('class', 'fa fa-chevron-down');
        } else {
            tabs.children('i.fa').attr('class', 'fa fa-chevron-down');
            tab.children('i.fa').attr('class', 'fa fa-chevron-up');
            caret_ups.addClass('hidden');
            caret_up.removeClass('hidden');
        }
    });
});
