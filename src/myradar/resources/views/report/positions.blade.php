@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Customer Positions</div>

                <div class="panel-body">
                    <div style="width: 100%; height: 500px;" id="map">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry"></script>
<script type="text/javascript">
var car = "M17.402,0H5.643C2.526,0,0,3.467,0,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759c3.116,0,5.644-2.527,5.644-5.644 V6.584C23.044,3.467,20.518,0,17.402,0z M22.057,14.188v11.665l-2.729,0.351v-4.806L22.057,14.188z M20.625,10.773 c-1.016,3.9-2.219,8.51-2.219,8.51H4.638l-2.222-8.51C2.417,10.773,11.3,7.755,20.625,10.773z M3.748,21.713v4.492l-2.73-0.349 V14.502L3.748,21.713z M1.018,37.938V27.579l2.73,0.343v8.196L1.018,37.938z M2.575,40.882l2.218-3.336h13.771l2.219,3.336H2.575z M19.328,35.805v-7.872l2.729-0.355v10.048L19.328,35.805z";
var icon = {
    path: car,
    scale: .5,
    strokeColor: 'white',
    strokeWeight: .10,
    fillOpacity: 1,
    fillColor: '#404040',
    offset: '5%',
    rotation: 30,
    anchor: new google.maps.Point(10, 25) // orig 10,50 back of car, 10,0 front of car, 10,25 center of car
};

var map;
var page = 0;
var current = 0;
var worker = null;
var positions = [];

function makeMarker(pos) {
    new google.maps.Marker({
        position: pos,
        title: 'Marker',
        map: map,
        icon: icon,
        // animation: google.maps.Animation.DROP,
    });
}

function addMarker() {
    if (current >= positions.length) {
        worker = null;
        return;
    }

    makeMarker(positions[current]);
    current++;

    worker = setTimeout(addMarker, 200);
}

function fetchCars() {
    page++;
    $.get('/report/positions/fetch?page='+page, function(response) {
        if (response.status == 1) {
            for (var i = 0; i < response.data.length; i++) {
                // positions.push({lat: response.data[i].lat, lng: response.data[i].lng});
                makeMarker({lat: response.data[i].lat, lng: response.data[i].lng});
            }

            // if (!worker) {
            //     worker = setTimeout(addMarker, 100);
            // }

            if (response.data.length > 0) {
                fetchCars();
            }
        }
    });
}


function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: new google.maps.LatLng(23.776750, 90.396653),
    });
    google.maps.event.addListenerOnce(map, 'idle', function(){
        fetchCars();
        var bound = map.getBounds();
        console.log(bound.getSouthWest().lat(), bound.getSouthWest().lng());
        console.log(bound.getNorthEast().lat(), bound.getNorthEast().lng());
    });
}

$(function() {
    initMap();
});
</script>
@endsection
