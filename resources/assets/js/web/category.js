$(document).ready(function() {
    $('div.list-infinity:first').infinitescroll({
      navSelector   : ".next",
      nextSelector  : ".next a",
      itemSelector  : "div.list-group-article",
      debug       : true,
      dataType    : 'html',
      path: function(index) {
        var nextHref = $('.next:last').children('a');
        if (nextHref.length > 0) {
           return nextHref.attr('href');
        }
      },
      finished: function () {
          $("#infscr-loading").remove();
      }
    }, function(elements, data, url) {
        if ($('.next:last').children('a').length == 0) {
            $('.list-infinity:first').infinitescroll('destroy');
        }
    });
})
