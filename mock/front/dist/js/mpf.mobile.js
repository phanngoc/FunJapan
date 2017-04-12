/*
 * MPF の Mobile 版レイアウトだけで実行される JavaScript を記述します。
 * このファイルに記述した JavaScript は Mobile 版の全てのページで実行されます。
 * 特定のページだけで必要なコードは含めないようにしてください。
 * 
 * 依存:
 * - jquery
 */

$(function () {
    //ドロップダウン内の項目をクリック時、すぐに消えないようにする。
    $('ul .dropdown-menu').click(function (e) {
        e.stopPropagation();
    });

    //Androidにおいてsubmitが自動でされるため、別途 検索ボタンのSubmit処理を記述。
    $('#global-nav form button').click(function () {
        var f = $(this).parents('form');
        //テキストボックスに値がある場合のみ検索する。
        if (f.find('input[type=text]').val() !== '') {
            f.submit();
        }
    });

    //トップに戻るボタンの配置
    var pagetop = $('.to-pagetop');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            pagetop.fadeIn();
        } else {
            pagetop.fadeOut();
        }
    });
    pagetop.click(function () {
        $('body, html').animate({ scrollTop: 0 }, 200);
        return false;
    });

    //navbar固定
    var affixElement = $('#nav-affix');
    var affixStartPosition = affixElement.offset().top;
    var collapseElement = $('#global-nav').find('div.collapse');

    affixElement.affix({
        offset: {
            top: function () {
                //トグルメニューが開いているときは、その高さを取得する
                if (collapseElement.hasClass('in')) {
                    return affixStartPosition + collapseElement.height();
                } else {
                    return affixStartPosition;
                }
            }
        }
    });

    //iOS8.4.1よりアンカーのhover時にページ遷移せず、処理がとまってしまう現象を回避。
    //iOSの仕様が、mouseover時にコンテンツに変化があると停止するようになっているため、
    //touchendイベントを定義し、処理を進める
    $('a').on('click touchend', function (e) {
    });
});