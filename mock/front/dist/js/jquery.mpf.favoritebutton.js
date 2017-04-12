/*
 * 記事の Favorite ボタンを動作させるための jQuery プラグインです。
 * 
 * 依存:
 * - jquery
 * - mpf.core
 * - mpf.linkbuttonbase
 * - mpf.textanimation
 */

(function ($) {
	if ($.fn.favoriteButton) return;

	var
		// CSS クラス名
		cssClassNames = {
			hasFavorite: 'active'
		},

		// 要素に拡張データを格納する際のキー
		dataKeys = {
			articleId: 'mpfArticleId'
		};

	$.fn.favoriteButton = function(context, sitecoreContext) {
		/// <summary>選択されている要素を Favorite ボタンとして動作するよう初期化します。</summary>
		/// <param name="context" type="Context">mpf.Context オブジェクト。</param>
		/// <param name="sitecoreContext" type="SitecoreContext">mpf.SitecoreContext オブジェクト。</param>
		/// <returns type="jQuery">このオブジェクト自身。</returns>
		return this.each(function() {
			new FavoriteButton($(this), context, sitecoreContext);
		});
	};

	function FavoriteButton($linkElem, context, sitecoreContext) {
		/// <summary>
		/// <paramref name="$linkElem"/> が Favorite ボタンとして動作するように初期化します。
		/// この関数は constructor です。new FavoriteButton(...) のように呼び出す必要があります。
		/// </summary>
		/// <param name="$linkElem" type="jQuery">Favorite ボタンの要素 1 つを選択した jQuery オブジェクト。</param>
		/// <param name="context" type="Context">mpf.Context オブジェクト。</param>
		/// <param name="sitecoreContext" type="SitecoreContext">mpf.SitecoreContext オブジェクト。</param>

		mpf.LinkButtonBase.call(this, $linkElem);

		this.isInteractive = $($linkElem).hasClass('engagement-interactive');
		this.context_ = context;
		this.sitecoreContext_ = sitecoreContext;

		//this.loadingAnim_ = mpf.TextAnimation.createLoading(this.ensureCountElem_());
	    //this.loadingAnim_.start();
		if (Modernizr.csstransitions) {
		    $linkElem.next("span.engagement-count").addClass("fa fa-spinner fa-spin");
		}

		this.reload($.proxy(function () { this.isEnabled(true); }, this));
	}

	// 連打防止のためにクリック後にボタンを disabled にするミリ秒数。
	FavoriteButton.minClickInterval = 1000;

	FavoriteButton.prototype = $.extend(new mpf.LinkButtonBase(), {
		isInteractive: false,
		hasFavorite_: false,
		count_: 0,

		buttonOnClick_: function () {
			if (this.isInteractive) {
				if (!this.context_.isLoggedIn) {
					location.href = this.sitecoreContext_.getLoginUrl();
					return;
				}

				if (!this.hasFavorite_) {
					this.add_();
				} else {
					this.remove_();
				}
			}
		},

		add_: function() {
			/// <summary>Web API を呼び出し、現在のユーザーで記事に Favorite を追加します。</summary>

			var originalCount = this.count_;

			// 連打防止
			this.isEnabled(false);

			// 体感速度を上げるため、実際の Web API 呼び出しより前に表示を更新する。
			this.setHasFavorite_(true);
			this.setCount_(originalCount + 1);

			$.ajax({
				url: this.context_.webApiSiteUrl + 'articles/' + this.$linkElem_.data(dataKeys.articleId) + '/favorites',
				type: 'POST',
				headers: this.context_.requestHeaders
			}).done($.proxy(function() {
				this.reload();
			}, this)).fail($.proxy(function() {
				this.setHasFavorite_(false);
				this.setCount_(originalCount);
			}, this));

			// 連打防止解除
			setTimeout($.proxy(function() { this.isEnabled(true); }, this), FavoriteButton.minClickInterval);
		},

		remove_: function() {
			/// <summary>Web API を呼び出し、記事から現在のユーザーの Favorite を削除します。</summary>

			var originalCount = this.count_;

			// 連打防止
			this.isEnabled(false);

			// 体感速度を上げるため、実際の Web API 呼び出しより前に表示を更新する。
			this.setHasFavorite_(false);
			this.setCount_(originalCount - 1);

			$.ajax({
				url: this.context_.webApiSiteUrl + 'articles/' + this.$linkElem_.data(dataKeys.articleId) + '/favorites',
				type: 'DELETE',
				headers: this.context_.requestHeaders
			}).done($.proxy(function() {
				this.reload();
			}, this)).fail($.proxy(function() {
				this.setHasFavorite_(true);
				this.setCount_(originalCount);
			}, this));

			// 連打防止解除
			setTimeout($.proxy(function() { this.isEnabled(true); }, this), FavoriteButton.minClickInterval);
		},

		setHasFavorite_: function(hasFavorite) {
			this.hasFavorite_ = hasFavorite;

			if (hasFavorite) {
			    this.$linkElem_.addClass(cssClassNames.hasFavorite);			    
			} else {
				this.$linkElem_.removeClass(cssClassNames.hasFavorite);
			}
		},

		reload: function(callback) {
			/// <summary>Web API を呼び出し Favorite ボタンの状態を更新します。</summary>
			/// <param name="callback">[Optional] 状態の更新が終わったら実行すべきコールバック関数。</param>

			var completeCount = 0,
				fireCallback = function() {
					if (++completeCount == 2) {
						if (callback) callback();
					}
				};

			this.loadState_().always(fireCallback);
			this.loadCount_().always(fireCallback);
		},

		loadState_: function() {
			/// <summary>Web API を呼び出し、現在のユーザーが記事に対して Favorite 済かどうかを読み込みます。</summary>

			return $.ajax({
				url: this.context_.webApiSiteUrl + 'my/favorites/articles/' + this.$linkElem_.data(dataKeys.articleId),
				type: 'GET',
				headers: this.context_.requestHeaders
			}).done($.proxy(function() {
				this.setHasFavorite_(true);
			}, this)).fail($.proxy(function() {
				this.setHasFavorite_(false);
			}, this));
		},

		loadCount_: function() {
			/// <summary>Web API を呼び出し、記事の Favorite 数を読み込みます。</summary>

			return $.ajax({
				url: this.context_.webApiSiteUrl + 'articles/' + this.$linkElem_.data(dataKeys.articleId) + "/favorites/count",
				type: 'GET'
			}).done($.proxy(function (count) {
			    //this.loadingAnim_.stop();
			    this.$linkElem_.next("span.engagement-count").removeClass("fa fa-spinner fa-spin");
				this.setCount_(count);
			}, this));
		},

		setCount_: function(count) {
			/// <summary>記事の Favorite 数の表示を更新します。</summary>
			/// <param name="count">新しい Favorite 数。</param>

			this.count_ = count;
			this.ensureCountElem_().text(count);
		},

		ensureCountElem_: function() {
			var $countElem = this.$linkElem_.next('span.engagement-count');
			if ($countElem.size() > 0) {
				return $countElem;
			} else {
				// ボタン要素の隣に Favorite 数表示用の <span> がない場合、動的に作成して挿入する。
				return $('<span class="engagement-count"></span>').insertAfter(this.$linkElem_);
			}
		}
	});
})(jQuery);