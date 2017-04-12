/*
 * MPF の Analytics ライブラリを定義します。
 * このファイルは Desktop / Mobile によらず全てのページでロードされます。
 * 特定のデバイスおよびページだけで必要なコードは含めないようにしてください。
 * 
 * 依存:
 * - jquery
 * - mpf.core
 */

(function(mpf) {
	if (mpf.Analytics) return;

	mpf.Analytics = function() {};

	mpf.Analytics.logPageAccess = function (itemId, context, isAuthenticated) {
	    $.ajax({
	        url: context.webApiSiteUrl + 'logs/pageaccess',
	        type: 'POST',
	        headers: context.requestHeaders,
	        data: {
	            ItemId: itemId,
	            IsAuthenticated: isAuthenticated
	}
		});
	};

	window.mpf = mpf;
})(window.mpf || {}); // Initialize namespace object.