/*
 * テキストを定期的に変更するアニメーションを実現します。
 * 
 * 依存:
 * - jquery
 */

(function(mpf) {
	if (mpf.TextAnimation) return;

	var defaultSettings = {
		getNextText: function(currentText) {
			return currentText;
		},
		currentText: '',
		interval: 100,
		shouldStop: function(currentText, count) {
			return false;
		}
	};

	mpf.TextAnimation = function($wrapElem, settings) {
		settings = $.extend(defaultSettings, settings);

		this.$wrapElem_ = $wrapElem;
		this.getNextText_ = settings.getNextText;
		this.currentText_ = settings.currentText;
		this.interval_ = settings.interval;
		this.shouldStop_ = settings.shouldStop;

		this.count_ = 0;
		this.intervalId_ = null;
	};

	mpf.TextAnimation.prototype = {
		start: function() {
			if (this.intervalId_) {
				return false;
			}
			this.intervalId_ = setInterval($.proxy(this.animate_, this), this.interval_);
			return true;
		},

		animate_: function() {
			if (this.shouldStop_(this.currentText_, this.count_)) {
				this.stop();
				return;
			}

			this.currentText_ = this.getNextText_(this.currentText_);
			this.refresh_();
			this.count_++;
		},

		refresh_: function() {
			this.$wrapElem_.text(this.currentText_);
		},

		stop: function() {
			if (!this.intervalId_) {
				return false;
			}
			clearInterval(this.intervalId_);
			this.intervalId_ = null;
			return true;
		}
	};

	mpf.TextAnimation.createLoading = function($wrapElem) {
		return new mpf.TextAnimation($wrapElem, {
			getNextText: function(currentText) {
				return currentText.length < 3 ? currentText + '.' : '.';
			},
			interval: 500
		});
	};

	window.mpf = mpf;
})(window.mpf || {}); // Initialize namespace object.