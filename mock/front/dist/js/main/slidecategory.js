$(function() {

  // el: element
  function getOffset(el) {
    var _x = 0;
    var _y = 0;
    while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
      _x += el.offsetLeft - el.scrollLeft;
      _y += el.offsetTop - el.scrollTop;
      el = el.offsetParent;
    }
    return {
      top: _y,
      left: _x
    };
  }

  var slideElement = $('#nav-affix .container');
  var $targetElement = slideElement.children('ul');
  var slideElementStartPosition = slideElement.position().left;
  var containerWidth = slideElement.outerWidth();
  var lastListElement = $targetElement.find('li:last');
  var lastListElementStartPosition = getOffset(lastListElement[0]).left;

  //全部入りきっているようなら、スライド機能は使用しない
  if (lastListElementStartPosition + lastListElement.width() > containerWidth) {
    //activeになってるカテゴリーを一番左に移動する
    var activeListElement = slideElement.find('li.active');
    if (activeListElement[0]) {

      var activeStartPosition = activeListElement.position().left;
      var marginLeft = 3;
      slideElement.css({
        'transform': 'translateX(' + (-activeStartPosition + marginLeft) + 'px)'
      });

      //最後の方のカテゴリーを左寄せすると、右に余白ができてしまうので制御する
      if ((lastListElement.position().left + lastListElement.width()) < containerWidth) {
        var translate = containerWidth - lastListElementStartPosition - lastListElement.width();
        slideElement.css({
          'transform': 'translateX(' + translate + 'px)'
        });
      }
    }

    //カテゴリースライドイベント
    slideElement.bind({

      /* フリック開始時 */
      'touchstart': function(e) {

        this.touchX = event.changedTouches[0].pageX;
        slideElementStartPosition = $targetElement.position().left;

        $targetElement.css({
          'transition-duration': '0ms'
        });

        this.touched = true;
      },

      /* フリック中 */
      'touchmove': function(e) {

        if (!this.touched) {
          return;
        }

        e.preventDefault();

        var distance = event.changedTouches[0].pageX - this.touchX + slideElementStartPosition;

        $targetElement.css({
          'transform': 'translateX(' + distance + 'px)'
        });
      },

      /* フリック終了 */
      'touchend': function(e) {

        if (!this.touched) {
          return;
        }

        if ($targetElement.position().left > 0) {
          $targetElement.css({
            'transition-duration': '600ms'
          });
          $targetElement.css({
            'transform': 'translateX(0px)'
          });
        }

        if ((lastListElement.position().left + lastListElement.width()) <= containerWidth) {

          var paddingText = (lastListElement.children('a').outerWidth() - lastListElement.children('a').width()) / 2;
          lastListElementStartPosition = getOffset(lastListElement[0]).left;

          var translate = containerWidth - lastListElementStartPosition - lastListElement.width() - paddingText;

          $targetElement.css({
            'transition-duration': '600ms',
            'transform': 'translateX(' + translate + 'px)'
          });
        }

        this.touched = false;
      }
    });
  };
});
