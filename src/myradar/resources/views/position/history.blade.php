@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/datetimepicker.min.css', $hasHttps) }}">
<style media="screen">

    .speed-factor-panel {
        border-bottom: 1px solid #E0E0E0;
    }
    .speed-factor {
        border-top:  1px solid #E0E0E0;
        border-left:  1px solid #E0E0E0;
        border-right:  1px solid #E0E0E0;
        text-align: center;
        color: #FFFFFF;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Past Tracking of <strong>{{$user->name}}</strong></div>

                <div class="panel-body">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="row row-eq-height" style="margin-bottom: 20px">
                        <div class="col-sm-4 col-sm-offset-1">
                            <div class="form">
                                <div class="form-group">
                                    <label for="datetimepicker1">From</label>
                                    <input type="text" class="form-control" id="datetimepicker1" placeholder="Select Time" />
                                </div>
                                <div class="form-group">
                                    <label for="datetimepicker2">To</label>
                                    <input type="text" class="form-control" id="datetimepicker2" placeholder="Select Time" />
                                </div>
                                <button type="button" class="btn btn-primary btn-block" id="filter">
                                    <i class="fa fa-search"></i> Show History
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-1 right-divider"></div>
                        <div class="col-sm-6 speed-factor-panel">
                            <div class="col-sm-2 speed-factor pull-down" data-height="40" data-bg="#26A69A" data-factor="5">
                                .5X <br> <i class="fa fa-check"></i>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2 speed-factor pull-down" data-height="60" data-bg="#66BB6A" data-factor="10">
                                1X <br> <i class="fa fa-check"></i>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2 speed-factor pull-down" data-height="90" data-bg="#26C6DA" data-factor="20">
                                2X <br> <i class="fa fa-check"></i>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2 speed-factor pull-down" data-height="130" data-bg="#7E57C2" data-factor="40">
                                4X <br> <i class="fa fa-check"></i>
                            </div>
                        </div>

                    </div>
                    <div style="width: 100%; height: 500px;" id="map">
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry"></script>
<script src="{{ asset('js/moment.min.js', $hasHttps) }}" charset="utf-8"></script>
<script src="{{ asset('js/datetimepicker.min.js', $hasHttps) }}" charset="utf-8"></script>
<script type="text/javascript">
google.maps.LatLng.prototype.distanceFrom = function (newLatLng) {
  // console.log('maam');
    var EarthRadiusMeters = 6378137.0; // meters
    var lat1 = this.lat();
    var lon1 = this.lng();
    var lat2 = newLatLng.lat();
    var lon2 = newLatLng.lng();
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return EarthRadiusMeters * c;
}
</script>
<script src="{{ asset('js/position/history.js', $hasHttps) }}" charset="utf-8"></script>
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
var from, to;
var user_id;
var worker = null;
var data = {};
var mapMarkers = {};
var currentPos = {};

function makeMarker(id, pos) {
    return new google.maps.Marker({
        position: pos,
        title: 'Marker',
        map: map,
        icon: icon,
    });
}

function initCar(k, arr) {
    data[k] = arr;
    currentPos[k] = 0;
    mapMarkers[k] = makeMarker(k, getNextPos(k));
}

function appendData(k, arr) {
    for (var i = 0; i < arr.length; i++) {
        data[k].push(arr[i]);
    }
}

function convertToLatLng(pos) {
    return new google.maps.LatLng(pos.lat, pos.lng);
}

function getNextPos(k) {
    var val = currentPos[k];
    if (val < data[k].length - 1) {
        return convertToLatLng(data[k][val]);
    }
    return null;
}

function getNextHeading(k) {
    var val = currentPos[k];
    if (val < data[k].length - 1) {
        return google.maps.geometry.spherical.computeHeading(
            convertToLatLng(data[k][val]),
            convertToLatLng(data[k][val+1])
        );
    }
    return null;
}

function updateMap() {
    for(var k in mapMarkers) {
        var inc = false;
        var pos = getNextPos(k);
        if (pos != null) {
            inc = true;
            mapMarkers[k].setPosition(pos);
        }
        var ang = getNextHeading(k);
        if (ang != null) {
            inc = true;
            var icon = mapMarkers[k].getIcon();
            icon.rotation = ang;
            mapMarkers[k].setIcon(icon);
        }

        if (inc == $hasHttps) {
            currentPos[k]++;
        }
    }

    worker = setTimeout(updateMap, 1000);
}

function fetchHistory() {
    page++;
    var url = '/tracking/records/fetch'
        + '?from=' + from
        + '&to=' + to
        + '&page=' + page
        + '&id=' + user_id;

    $.get(url, function(response) {
        var repeat = false;
        if (response.status == 1) {
            for (var k in response.data) {
                if (response.data[k].length > 0) {
                    repeat = true;
                    if (!mapMarkers.hasOwnProperty(k)) {
                        initCar(k, response.data[k]);
                    } else {
                        appendData(k, response.data[k]);
                    }
                }
            }

            if (worker == null) {
                worker = setTimeout(updateMap, 0);
            }

            if (repeat == $hasHttps) {
                fetchHistory();
            }

        }
    });
}

function startHistoryFetching() {
    removeHistoryCache();

    from = $('#datetimepicker1').val();
    to = $('#datetimepicker2').val();

    fetchHistory();
}

function removeHistoryCache() {
    page = 0;
    if (worker != null) {
        clearTimeout(worker);
        worker = null;
    }
    currentPos = {};
    data = {};
    for (var m in mapMarkers) {
        mapMarkers[m].setMap(null);
    }
    mapMarkers = {};
}

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: new google.maps.LatLng(23.776750, 90.396653),
    });
    google.maps.event.addListenerOnce(map, 'idle', function(){
        // fetchCars();
        // var bound = map.getBounds();
        // console.log(bound.getSouthWest().lat(), bound.getSouthWest().lng());
        // console.log(bound.getNorthEast().lat(), bound.getNorthEast().lng());
    });
}

$(function() {
    user_id = $('input[name="user_id"]').val();
    var timepickerOptions = {
        format: 'D MMM YYYY, hh:mm A',
    };
    $('#datetimepicker1').datetimepicker(timepickerOptions);
    $('#datetimepicker2').datetimepicker(timepickerOptions);

    // initMap();

    $('#filter').click(function() {
        // startHistoryFetching();
    })
});
</script>
@endsection
