
$(function () {
    function createMap(mapElementId) {
        var mapElement = document.getElementById(mapElementId);
        if (!mapElement)
            return;

        var instance = new google.maps.Map(mapElement);

        this.map = {
            instance: instance,
            options: {
                zoom: {},
                center: {},
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scaleControl: true,
                mapTypeControl: false
            },
            markers: [],
            marker: function () {
                return {
                    lat: {},
                    lng: {},
                    title: {},
                    category: {},
                    content: {},
                    options: {
                        icon: {}
                    }
                }
            },
            currentInfoWindow: null
        };

        this.setMarkers = function () {
            var mapMarkers = [];
            map = this.map;
            $.each(this.map.markers, function (i, value) {

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(value.lat, value.lng),
                    icon: value.options.icon,
                    map: map.instance,
                    title: value.title,
                    category: value.category
                });

                if (value.content.length) {
                    google.maps.event.addListener(marker, 'click', function () {

                        if (map.currentInfoWindow) {
                            map.currentInfoWindow.close();
                        };

                        map.currentInfoWindow = new google.maps.InfoWindow({
                            content: value.content
                        });

                        map.currentInfoWindow.open(map.instance, marker);
                    });
                };

                mapMarkers.push(marker);
            });

            var mc = new MarkerClusterer(map.instance, mapMarkers);
        };

        this.setOptions = function () {
            this.map.instance.setOptions(this.map.options);
        };

        return this;
    };

    function getCenterPositionByCountry() {
        switch (MPF.current.country) {
            case 'id-ID':
                return { lat: -6.208415, lng: 106.841191 };
                break;
            case 'th-TH':
                return { lat: 13.756203, lng: 100.500599 };
                break;
            case 'ms-MY':
                return { lat: 3.131952, lng: 101.679397 };
                break;
            case 'zh-TW':
                return { lat: 25.033714, lng: 121.559250 };
                break;
            default:
        };
    };

    //GeoLocation
    if ($('#geolocation-map').length) {
        var geolocationMap = new createMap('geolocation-map');
        geolocationMap.map.options.zoom = 8;

        var centerPotision = getCenterPositionByCountry();
        geolocationMap.map.options.center = new google.maps.LatLng(centerPotision.lat, centerPotision.lng);

        geolocationMap.setOptions();

        var originalIcon = new google.maps.MarkerImage("/Mpf/Images/map-marker.png");
        originalIcon.scaledSize = new google.maps.Size(30, 30);

        $.each($('div.marker-info'), function (i, value) {
            var dataElement = $(value);

            var marker = new geolocationMap.map.marker();
            marker.lat = dataElement.attr('data-latitude');
            marker.lng = dataElement.attr('data-longitude');
            marker.options.icon = originalIcon;
            geolocationMap.map.markers.push(marker);
        });

        geolocationMap.setMarkers();

        //travelmap
    } else if ($('#travel-map').length) {
        $('#travel-map').css('border', '2px inset gray');

        var travelMap = new createMap('travel-map');

        travelMap.map.options.zoom = 11;
        travelMap.map.options.center = new google.maps.LatLng('35.681394', '139.766252');

        travelMap.setOptions();

        $.each($(document.getElementsByClassName('marker-info')), function (i, value) {
            var dataElement = $(value);
            var marker = new travelMap.map.marker();

            var originalIcon = new google.maps.MarkerImage(dataElement.attr('data-pin-image'));
            originalIcon.scaledSize = new google.maps.Size(30, 30);
            marker.options.icon = originalIcon;

            marker.lat = dataElement.attr('data-latitude');
            marker.lng = dataElement.attr('data-longitude');
            marker.title = dataElement.attr('data-title');
            marker.category = dataElement.attr('data-category');
            var articleUrl = dataElement.attr('data-article-url');
            marker.content = '<div class="map-info">' +
                                 '<div class="row">' +
                                     '<div class="col-xs-6 col-sm-7">' +
                                         '<a href="' + articleUrl + '" target="_blank">' +
                                              '<img src="' + dataElement.attr('data-image') + '"></img>' +
                                          '</a>' +
                                      '</div>' +
                                      '<div class="col-xs-6 col-sm-5 content">' +
                                         '<p style ="color:red" class="h6">' + dataElement.attr('data-category') + '</p>' +
                                         '<a href="' + articleUrl + '" target="_blank">' +
                                           '<p class="h6 title">' + dataElement.attr('data-title') + '</p>' +
                                         '</a>' +
                                         '<a href="' + articleUrl + '" target="_blank">' +
                                           '<p class="detail">>> Detail</p>' +
                                         '</a>' +
                                      '</div>' +
                                 '</div>' +
                              '</div>';

            travelMap.map.markers.push(marker);
        });

        travelMap.setMarkers();

        //CouponMap
    } else if ($('#coupon-map').length) {
        $('#coupon-map').css('border', '2px inset gray');

        var couponMap = new createMap('coupon-map');

        couponMap.map.options.zoom = 11;

        var centerPotision = getCenterPositionByCountry();
        couponMap.map.options.center = new google.maps.LatLng(centerPotision.lat, centerPotision.lng);

        couponMap.setOptions();

        $.each($(document.getElementsByClassName('marker-info')), function (i, value) {
            var dataElement = $(value);
            var marker = new couponMap.map.marker();

            var originalIcon = new google.maps.MarkerImage(dataElement.attr('data-pin-image'));
            originalIcon.scaledSize = new google.maps.Size(30, 30);
            marker.options.icon = originalIcon;

            marker.lat = dataElement.attr('data-latitude');
            marker.lng = dataElement.attr('data-longitude');
            marker.title = dataElement.attr('data-title');
            marker.category = dataElement.attr('data-category');
            var articleUrl = dataElement.attr('data-article-url');
            marker.content = '<div class="map-info">' +
                                            '<div class="row">' +
                                                '<div class="col-xs-6 col-sm-7">' +
                                                    '<a href="' + articleUrl + '" target="_blank">' +
                                                         '<img src="' + dataElement.attr('data-image') + '"></img>' +
                                                     '</a>' +
                                                 '</div>' +
                                                 '<div class="col-xs-6 col-sm-5 content">' +
                                                    '<p style ="color:red" class="h6">' + dataElement.attr('data-category') + '</p>' +
                                                    '<a href="' + articleUrl + '" target="_blank">' +
                                                      '<p class="h6 title">' + dataElement.attr('data-title') + '</p>' +
                                                    '</a>' +
                                                    '<a href="' + articleUrl + '" target="_blank">' +
                                                      '<p class="detail">>> Detail</p>' +
                                                    '</a>' +
                                                 '</div>' +
                                            '</div>' +
                                         '</div>';

            couponMap.map.markers.push(marker);
        });

        couponMap.setMarkers();
    };
});