/*
 * MPF の User Preference ライブラリを定義します。
 * User Preference とは、ユーザー毎の設定項目のことです。
 * このファイルは Desktop / Mobile によらず全てのページでロードされます。
 * 特定のデバイスおよびページだけで必要なコードは含めないようにしてください。
 * 
 * 依存:
 * - jquery
 * - jquery.cookie
 */

(function($, mpf) {
	if (mpf.UserPreference) return;

	var cookieKey = 'MPF_UserPreference',
		cookieOptions = {
			expires: 365,
			path: '/'
		};

	mpf.UserPreference = function(items) {
		this.items_ = $.extend({}, items);
	};

	mpf.UserPreference.prototype = {
		get: function(name) {
			return this.items_[name];
		},

		set: function(name, value) {
			this.items_[name] = value;
		},

		remove: function(name) {
			delete this.items_[name];
		},

		save: function() {
			$.cookie(cookieKey, this.toString(), cookieOptions);
		},

		hasValue: function(name) {
			return this.items_.hasOwnProperty(name);
		},

		toString: function() {
			return JSON.stringify(this.items_);
		}
	};

	mpf.UserPreference.load = function() {
		var itemsJson = $.cookie(cookieKey),
			items = undefined;
		if (itemsJson) {
			try {
				items = JSON.parse(itemsJson);
			} catch (e) {
			}
		}
		return new mpf.UserPreference(items);
	};

	mpf.UserPreference.get = function(name) {
		return mpf.UserPreference.load().get(name);
	};

	mpf.UserPreference.set = function(name, value) {
		var up = mpf.UserPreference.load();
		up.set(name, value);
		up.save();
	};

	mpf.UserPreference.clear = function() {
		$.removeCookie(cookieKey, cookieOptions);
	};
})(jQuery, window.mpf || {}); // Initialize namespace object.