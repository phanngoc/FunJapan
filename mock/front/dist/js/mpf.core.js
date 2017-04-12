/*
 * MPF の JavaScript コアライブラリを定義します。
 * このファイルは Desktop / Mobile によらず全てのページでロードされます。
 * 特定のデバイスおよびページだけで必要なコードは含めないようにしてください。
 * 
 * 依存:
 * - jquery
 */

function initMPF(args) {
    window.MPF = {
        config: {
            api: {
                baseUrl: args.apiBaseUrl,
                authToken: args.apiAuthToken
            },
            loginUrl: args.loginUrl,
            registerUrl: args.registerUrl
        },

        current: {
            country: args.country,
            user: {
                userId: args.userId,
                isAuthenticated: args.isAuthenticated,
                isAdmin: args.isAdmin,
                visitorId: args.visitorId,
                trackerUserId: args.trackerUserId
            },
            itemId: args.itemId,
            device: {
                isDesktop: args.isDesktop,
                isMobile: args.isMobile
            },
        },

        preference: {

        },

        api: {
            article: {
                comment: {},
                photo: {}
            },
            geolocation: {}
        },

        getLoginUrl: function () {
            return this.config.loginUrl + '?itemid=' + this.current.itemId;
        },

        getRegisterUrl: function () {
            return this.config.registerUrl + '?itemid=' + this.current.itemId;
        },
        getPublicUserProfile: function (userId, callbacks) {
            var deferred = $.Deferred();

            $.ajax({
                type: 'GET',
                url: this.config.api.baseUrl + 'odata/PublicUserProfiles(' + userId + ')',
                success: deferred.resolve,
                error: deferred.reject
            });

            return deferred.promise();
        }
    };
}

(function (mpf) {
    if (mpf.Context) return;

    mpf.Context = function (args) {
        args = args || {};
        this.webApiSiteUrl = args.webApiSiteUrl;
        this.authTicket = args.authTicket;
        this.currentUserId = args.currentUserId;
        this.isLoggedIn = args.isLoggedIn;
        this.requestHeaders = { 'X-MPF-AuthenticationTicket': this.authTicket };
    };

    mpf.SitecoreContext = function (args) {
        this.currentItemId = args.currentItemId;
        this.loginPageUrl = args.loginPageUrl;
    };

    mpf.SitecoreContext.prototype = {
        getLoginUrl: function () {
            var queryString = $.param($.extend({}, { itemid: this.currentItemId }));
            return queryString ? this.loginPageUrl + '?' + queryString : this.loginPageUrl;
        }
    };

    mpf.Resources = function (source) {
        /// <summary>
        /// 文字列をキーにして任意のオブジェクトを登録するリソースディクショナリオブジェクトを初期化します。
        /// この関数は constructor です。
        /// </summary>

        this.source_ = source || {};
    };

    mpf.Resources.prototype = {
        get: function (key) {
            /// <summary>指定されたキーに対応するリソースを取得します。対応するリソースが見つからない場合はキーをそのまま返します。</summary>
            /// <param name="key">リソースのキー。</param>
            /// <returns type="Object">指定されたキーに対応するリソース。対応するリソースが見つからない場合はキー。</returns>

            return this.source_[key] || key;
        },

        add: function (source) {
            /// <summary>このインスタンスにリソースを追加します。</summary>
            /// <param name="source">
            /// プロパティ名がキー、プロパティ値がリソースの Object。
            /// 例えば次のコードはキー: 'foo' で 'bar' を、キー: 'baz' で true (Boolean 値) を追加します。
            /// mpf.Resources.getDefault().add({'foo': 'bar', 'baz': true});
            /// </param>

            this.source_ = $.extend(this.source_, source || {});
        }
    };

    mpf.Resources.getDefault = (function () {
        var resources = new mpf.Resources();
        return function () {
            /// <summary>mpf.Resources クラスの Singleton デフォルトインスタンスを返します。</summary>
            /// <returns type="mpf.Resources">mpf.Resources クラスの Singleton デフォルトインスタンス。</returns>

            return resources;
        };
    })();

    //$(function () {
    //    //RelatedPost内、イメージ拡大メソッド	
    //    var resizeRelatedPostImages = function () {
    //        var oldValue = $('.list-group-related-article .list-group-item .row > div:first').width();
    //        var newValue = oldValue + 10;
    //        $('.list-group-related-article .list-group-item .img-thumbnail').css('max-width', 'none');
    //        $('.list-group-related-article .list-group-item .img-thumbnail').width(newValue);
    //        $('.list-group-related-article .list-group-item .img-thumbnail').height(newValue);
    //    };

    //    //Load時のRelatedPost内のイメージを大きくする処理を、
    //    //window幅変更時にも入れる。
    //    var timer = false;
    //    $(window).resize(function () {
    //        if (timer !== false) {
    //            clearTimeout(timer);
    //        }

    //        timer = setTimeout(function () {
    //            resizeRelatedPostImages();
    //        }, 200);
    //    });

    //    //Load時、RelatedPost内イメージを大きくする。
    //    resizeRelatedPostImages();
    //});

    // 連続クリック防止メソッド
    $(function () {
        $('.prevent-button-doubleclick').click(function () {
            $(this).addClass('disabled');
        });
    });

    // Window.close()がFireFoxやChromeだと動かないのでカスタムメソッドを作成する
    mpf.close = function () {
        var nvua = navigator.userAgent;
        if (nvua.indexOf('MSIE') >= 0) {
            if (nvua.indexOf('MSIE 5.0') == -1) {
                top.opener = '';
            }
        }
        else if (nvua.indexOf('Gecko') >= 0) {
            top.name = 'CLOSE_WINDOW';
            wid = window.open('', 'CLOSE_WINDOW');
        }
        top.close();
    };

    window.mpf = mpf;
})(window.mpf || {}); // Initialize namespace object.
