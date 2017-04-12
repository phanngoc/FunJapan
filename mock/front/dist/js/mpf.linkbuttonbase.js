/*
 * link 要素 (<a>) をボタンとして動作させるクラスの基底クラスです。
 * 
 * 依存:
 * - jquery
 */

(function(mpf) {
	if (mpf.LinkButtonBase) return;

	mpf.LinkButtonBase = function($linkElem) {
		this.$linkElem_ = $linkElem;
	};

	mpf.LinkButtonBase.prototype = {
		isEnabledField_: false,

		isEnabled: function(value) {
			if (value === undefined) {
				return this.isEnabledField_;
			}

			if (value === this.isEnabledField_) {
				return this.isEnabledField_;
			}

			this.isEnabledField_ = value;

			if (value) {
				this.$linkElem_.click($.proxy(this.buttonOnClick_, this));
				this.$linkElem_.prop('disabled', false);
			} else {
				this.$linkElem_.unbind('click', $.proxy(this.buttonOnClick_, this));
				this.$linkElem_.prop('disabled', true);
			}

			return this.isEnabledField_;
		},

		// Virtual Method
		buttonOnClick_: function() {}
	};

	window.mpf = mpf;
})(window.mpf || {}); // Initialize namespace object.