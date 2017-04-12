
// 位置情報をかきこむ
MPF.api.geolocation.postGeoLocation = function (visitorId, trackerUserId, country, result, lat, lng) {
    var deferred = $.Deferred();

    $.ajax({
        type: 'POST',
        url: MPF.config.api.baseUrl + 'odata/GeoLocation',
        headers: { 'X-MPF-AuthenticationTicket': MPF.config.api.authToken },
        data: {
            VisitorId: visitorId,
            TrackerUserId: trackerUserId,
            Country: country,
            Result: result,
            Lat: lat,
            Lng: lng
        },
        success: deferred.resolve,
        error: deferred.reject
    });

    return deferred.promise();
}
