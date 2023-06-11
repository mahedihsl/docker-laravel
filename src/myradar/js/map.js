var dirService, renderer;
var map, marker;
var polyline, distance;
var animator;
var places = [
    {lat: 23.797251, lng: 90.401509},
    {lat: 23.796573, lng: 90.402148},
    // {lat: 23.795930, lng: 90.401343},
    // {lat: 23.795459, lng: 90.401268},
    // {lat: 23.794880, lng: 90.401182},
    // {lat: 23.794438, lng: 90.401085},
    {lat: 23.794290, lng: 90.402222},
    {lat: 23.794221, lng: 90.402716},
    {lat: 23.794172, lng: 90.403252},
    {lat: 23.794084, lng: 90.403649},
    {lat: 23.794028, lng: 90.404307},
    {lat: 23.793978, lng: 90.404655},
];

function initMap() {
    var pos = new google.maps.LatLng(places[0].lat, places[0].lng);
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: pos,
    });

    animator = EasingAnimator.makeFromCallback(function(latLng){
        console.log("changing center: ", latLng);
        map.setCenter(latLng)
    });

    var car = "M17.402,0H5.643C2.526,0,0,3.467,0,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759c3.116,0,5.644-2.527,5.644-5.644 V6.584C23.044,3.467,20.518,0,17.402,0z M22.057,14.188v11.665l-2.729,0.351v-4.806L22.057,14.188z M20.625,10.773 c-1.016,3.9-2.219,8.51-2.219,8.51H4.638l-2.222-8.51C2.417,10.773,11.3,7.755,20.625,10.773z M3.748,21.713v4.492l-2.73-0.349 V14.502L3.748,21.713z M1.018,37.938V27.579l2.73,0.343v8.196L1.018,37.938z M2.575,40.882l2.218-3.336h13.771l2.219,3.336H2.575z M19.328,35.805v-7.872l2.729-0.355v10.048L19.328,35.805z";
    var icon = {
        path: car,
        scale: .7,
        strokeColor: 'white',
        strokeWeight: .10,
        fillOpacity: 1,
        fillColor: '#404040',
        offset: '5%',
        rotation: 30,
        anchor: new google.maps.Point(10, 25) // orig 10,50 back of car, 10,0 front of car, 10,25 center of car
    };

    // SlidingMarker
    marker = new google.maps.Marker({
        position: pos,
        title: 'Hyper Systems Ltd.',
        map: map,
        icon: icon,
        duration: 1000,
    });
}

function changePos(i) {
    if (i >= places.length) {
        marker.getMap().panTo(new google.maps.LatLng(places[i-1].lat, places[i-1].lng));
        return;
    }

    if (i > 1) {
        var ic = marker.getIcon();
        ic.rotation = google.maps.geometry.spherical.computeHeading(
            new google.maps.LatLng(places[i-1].lat, places[i-1].lng),
            new google.maps.LatLng(places[i].lat, places[i].lng)
        );
        marker.setIcon(ic);

        marker.getMap().panTo(marker.getPosition());

        // var point = marker.getMap().getCenter();
        // animator.easeProp({
        //     lat: point.lat(),
        //     lng: point.lng(),
        // }, places[i]);
    }

    marker.setPosition(new google.maps.LatLng(places[i].lat, places[i].lng));

    setTimeout('changePos('+(i+1)+')', 1200);
}

/**
 * convert {lat, lng} object to google.maps.LatLng object
 * @param  {lat, lng} o an object of sign {lat, lng}
 * @return {google.maps.LatLng} converted object
 */
function toLatLngObj(o) {
    return new google.maps.LatLng(o.lat, o.lng);
}

/**
 * returns the last location of the route returned from directions service API
 * @return {google.maps.LatLng} last location coordinate
 */
function getEndLocation() {
    return polyline.getPath()[polyline.getPath().length - 1];
}

function isBoundaryCrossed(p) {
    var bounds = map.getBounds();
    var ne = bounds.getNorthEast();
    var sw = bounds.getSouthWest();
    var nw = new google.maps.LatLng(ne.lat(), sw.lng());
    var se = new google.maps.LatLng(sw.lat(), ne.lng());
}

function animate(d) {
    if (d > distance) {
        var end = getEndLocation();
        console.log("end: ", distance);
        // map.panTo(end);
        // marker.setPosition(end);
        return;
    }
    var p = polyline.GetPointAtDistance(d);
    // map.panTo(p);

    // var point = marker.getMap().getCenter();
    // animator.easeProp({
    //     lat: point.lat(),
    //     lng: point.lng(),
    // }, {lat: p.lat(), lng: p.lng()});

    var lastPosn = marker.getPosition();
    marker.setPosition(p);
    var heading = google.maps.geometry.spherical.computeHeading(lastPosn, p);
    var icon = marker.getIcon();
    icon.rotation = heading;
    marker.setIcon(icon);
    // updatePoly(d);
    timerHandle = setTimeout("animate(" + (d + 2.7) + ")", 100);
}

$(function() {
    initMap();
    // setTimeout('changePos(0)', 2000);

    polyline = new google.maps.Polyline({
        path: [],
        strokeColor: '#57F2F7',
        strokeWeight: 3,
    });

    dirService = new google.maps.DirectionsService();
    renderer = new google.maps.DirectionsRenderer({map: map});

    var way = [];
    for (var i = 1; i < places.length - 1; i++) {
        way.push({
            location: new google.maps.LatLng(places[i].lat, places[i].lng),
            stopover: false,
        });
    }

    var st = new google.maps.LatLng(places[0].lat, places[0].lng);
    var en = new google.maps.LatLng(places[places.length - 1].lat, places[places.length - 1].lng);

    dirService.route({
        origin: st,
        destination: en ,
        travelMode: google.maps.DirectionsTravelMode.DRIVING,
        waypoints: way,
    }, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            renderer.setDirections(response);

            var bound = new google.maps.LatLngBounds();
            var route = response.routes[0];
            var legs = route.legs;
            for (var i = 0; i < legs.length; i++) {
                var steps = legs[i].steps;

                for (var j = 0; j < steps.length; j++) {
                    var path = steps[j].path;

                    for (var k = 0; k < path.length; k++) {
                        polyline.getPath().push(path[k]);
                        bound.extend(path[k]);
                    }
                }
            }

            map.fitBounds(bound);
            distance = polyline.Distance();
            animate(1);
        }
    });
});

google.maps.LatLng.prototype.distanceFrom = function (newLatLng) {
    var EarthRadiusMeters = 6378137.0; // meters
    var lat1 = this.lat();
    var lon1 = this.lng();
    var lat2 = newLatLng.lat();
    var lon2 = newLatLng.lng();
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = EarthRadiusMeters * c;
    return d;
}

google.maps.LatLng.prototype.latRadians = function () {
    return this.lat() * Math.PI / 180;
}

google.maps.LatLng.prototype.lngRadians = function () {
    return this.lng() * Math.PI / 180;
}

// === A method which returns the length of a path in metres ===
google.maps.Polygon.prototype.Distance = function () {
    var dist = 0;
    for (var i = 1; i < this.getPath().getLength(); i++) {
        dist += this.getPath().getAt(i).distanceFrom(this.getPath().getAt(i - 1));
    }
    return dist;
}

// === A method which returns a GLatLng of a point a given distance along the path ===
// === Returns null if the path is shorter than the specified distance ===
google.maps.Polygon.prototype.GetPointAtDistance = function (metres) {
    // some awkward special cases
    if (metres == 0) return this.getPath().getAt(0);
    if (metres < 0) return null;
    if (this.getPath().getLength() < 2) return null;
    var dist = 0;
    var olddist = 0;
    for (var i = 1;
    (i < this.getPath().getLength() && dist < metres); i++) {
        olddist = dist;
        dist += this.getPath().getAt(i).distanceFrom(this.getPath().getAt(i - 1));
    }
    if (dist < metres) {
        return null;
    }
    var p1 = this.getPath().getAt(i - 2);
    var p2 = this.getPath().getAt(i - 1);
    var m = (metres - olddist) / (dist - olddist);
    return new google.maps.LatLng(p1.lat() + (p2.lat() - p1.lat()) * m, p1.lng() + (p2.lng() - p1.lng()) * m);
}

// === A method which returns an array of GLatLngs of points a given interval along the path ===
google.maps.Polygon.prototype.GetPointsAtDistance = function (metres) {
    var next = metres;
    var points = [];
    // some awkward special cases
    if (metres <= 0) return points;
    var dist = 0;
    var olddist = 0;
    for (var i = 1;
    (i < this.getPath().getLength()); i++) {
        olddist = dist;
        dist += this.getPath().getAt(i).distanceFrom(this.getPath().getAt(i - 1));
        while (dist > next) {
            var p1 = this.getPath().getAt(i - 1);
            var p2 = this.getPath().getAt(i);
            var m = (next - olddist) / (dist - olddist);
            points.push(new google.maps.LatLng(p1.lat() + (p2.lat() - p1.lat()) * m, p1.lng() + (p2.lng() - p1.lng()) * m));
            next += metres;
        }
    }
    return points;
}

// === A method which returns the Vertex number at a given distance along the path ===
// === Returns null if the path is shorter than the specified distance ===
google.maps.Polygon.prototype.GetIndexAtDistance = function (metres) {
    // some awkward special cases
    if (metres == 0) return this.getPath().getAt(0);
    if (metres < 0) return null;
    var dist = 0;
    var olddist = 0;
    for (var i = 1;
    (i < this.getPath().getLength() && dist < metres); i++) {
        olddist = dist;
        dist += this.getPath().getAt(i).distanceFrom(this.getPath().getAt(i - 1));
    }
    if (dist < metres) {
        return null;
    }
    return i;
}
// === Copy all the above functions to GPolyline ===
google.maps.Polyline.prototype.Distance = google.maps.Polygon.prototype.Distance;
google.maps.Polyline.prototype.GetPointAtDistance = google.maps.Polygon.prototype.GetPointAtDistance;
google.maps.Polyline.prototype.GetPointsAtDistance = google.maps.Polygon.prototype.GetPointsAtDistance;
google.maps.Polyline.prototype.GetIndexAtDistance = google.maps.Polygon.prototype.GetIndexAtDistance;


// --------------------------------------------------

var EasingAnimator = function(opt){
        opt = opt || {};
        this.easingInterval = opt.easingInterval;
        this.duration = opt.duration || 1000;
        this.step = opt.step || 5;
        this.easingFn = opt.easingFn  || function easeInOutElastic(t, b, c, d) {
            if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
            return -c/2 * ((t-=2)*t*t*t - 2) + b;
        };
        this.callBack = opt.callBack || function(){};
    };

EasingAnimator.makeFromCallback = function(callBack){
    return new EasingAnimator({
        callBack: callBack
    });
};

EasingAnimator.prototype.easeProp = function(obj, propDict){
    propDict = propDict || {};

    var self = this,
        t = 0,
        out_vals = JSON.parse(JSON.stringify(obj));

    clearInterval(self.easingInterval);
    self.easingInterval = setInterval(function(){
        t+= self.step;
        if (t >= self.duration) {
            clearInterval(self.easingInterval);
            self.callBack(propDict);
            return;
        }
        var percent = self.easingFn(t, 0, 1, self.duration);
        Object.keys(propDict).forEach(function(key, i) {
            var old_val = obj[key];

            out_vals[key] = old_val - percent*(old_val - propDict[key]);
        });
        self.callBack(out_vals);
    }, self.step);
};

function initialize() {
    var points = [
            {lat: -34.397, lng: 150.644},
            {lat: -31.445, lng: 150.657}
        ],
       sel_point = 0;

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: points[sel_point]
    });
    var easingAnimator = EasingAnimator.makeFromCallback(function(latLng){
        map.setCenter(latLng)
    });
    Array.prototype.slice.apply(document.querySelectorAll('.map_keep__button'))
        .map(function(dom_elem, i) {
            dom_elem.addEventListener('click', function(event){
                var point = map.getCenter();

                easingAnimator.easeProp({
                    lat: point.lat(),
                    lng: point.lng(),
                }, points[i]);
            });
    });
}

// google.maps.event.addDomListener(window, 'load', initialize);
