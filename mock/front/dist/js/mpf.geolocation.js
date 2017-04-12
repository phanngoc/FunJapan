$(function () {
    // 対応している場合
    if (navigator.geolocation) {
        // 現在地を取得
        navigator.geolocation.getCurrentPosition(

            // [第1引数] 取得に成功した場合の関数
            function (position) {
                // 取得したデータの整理
                var data = position.coords;

                // 位置情報をDBにかきこむ
                MPF.api.geolocation.postGeoLocation(MPF.current.user.visitorId, MPF.current.user.trackerUserId, MPF.current.country, 'SUCCESS', data.latitude, data.longitude);
            },

            // [第2引数] 取得に失敗した場合の関数
            function (error) {

                // エラー番号に対応したメッセージ
                var errorInfo = [
                    "UNKNOWN_ERROR",
                    "PERMISSION_DENIED",
                    "POSITION_UNAVAILABLE",
                    "TIMEOUT"
                ];

                // error内容をDBにかきこむ
                MPF.api.geolocation.postGeoLocation(MPF.current.user.visitorId, MPF.current.user.trackerUserId, MPF.current.country, errorInfo[error.code], '', '');
            },

            // [第3引数] オプション
            {
                "enableHighAccuracy": false,
                "timeout": 8000,
                "maximumAge": 2000,
            }
        );
    }

        // 対応していない場合
    else {
        // error内容をDBにかきこむ
        MPF.api.geolocation.postGeoLocation(MPF.current.user.visitorId, MPF.current.user.trackerUserId, MPF.current.country, 'SERVICE_UNAVAILABLE', '', '');
    }
});