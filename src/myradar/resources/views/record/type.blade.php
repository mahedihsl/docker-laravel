@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datetimepicker.min.css') }}">
    <style media="screen">
        .sm_select {
            width: 100px;
            float: left;
        }
        #wrapper { position: relative; }
        #over_map { position: absolute; top: 10px; right: 10px; z-index: 99; }


    </style>

   <style>
   #engine_status_alert{
     float: left;
   }

   </style>
@endsection



@section('content')

<div class="row">
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">Customer Positions</div>
<div id='instructions'></div>
            <div class="panel-body">
              <div class="row">
                  <div class="col-md-8 col-md-offset-2">
                      <h3>Select Tracking Type</h3>

  <form class="form" action="/tracking/report" method="get">

                          <input type="checkbox" name="toggle" checked data-on-text="LIVE" data-off-text="PAST">
                           <input type="hidden" name="type">
                             <input type="hidden" name="user_id" value="{{Request::segment(2)}}">
                            <button type="button" id="filter" class="btn btn-success pull-right">Continue</button>
  <br>  <h2 id="engine_status_alert"></h2>
                           <div style="margin-top: 20px;" id="sub-form">

                                   <input type="text" name="date" id="date"  data-toggle="datepicker" class="form-control">

                               <div class="form-group">
                                   <label>From:</label><br>
                                   <select class="form-control sm_select hour" name="from_hr" id="from_hr"></select>
                                   <select class="form-control sm_select mint" name="from_mn" id="from_mn"></select>
                                   <select class="form-control sm_select am" name="from_am" id="from_am"></select>
                               </div>

                               <br>

                               <div class="form-group">
                                   <label>To:</label><br>
                                   <select class="form-control sm_select hour" name="to_hr" id="to_hr"></select>
                                   <select class="form-control sm_select mint" name="to_mn" id="to_mn"></select>
                                   <select class="form-control sm_select am" name="to_am" id = "to_am"></select>
                               </div>
                           </div>
                           <br><br>

                      </form>




                      <form class="form">
                            <input type="checkbox" id="toggle_car" name="toggle_car" checked data-on-text="CAR-LOCKED" data-off-text="CAR-UNLOCKED"><br><br>

                               <input type="hidden" name="user_id" value="{{Request::segment(2)}}">
                      </form>





                  </div>

              </div>
              <div id="wrapper">
                <div style="width: 100%; height: 500px;" id="map">

                </div>

             <div id="over_map">
              <button id="show_time" class="btn btn-primary"><div id='map_time'>12.00</div></button></div>
             </div>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/bootstrap-switch.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/moment.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/gmaps.js') }}" charset="utf-8"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry"></script>

<script src="{{ asset('js/jquery.easing.js') }}" charset="utf-8"></script>
<script src="https://js.pusher.com/4.0/pusher.min.js"></script>
<script src="http://underscorejs.org/underscore-min.js"></script>
<script src= "https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/en-gb.js"></script>


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
var bound;
var bounds,ne_lat,se_lat,se_lng,ne_lng;
var map;
var page = 0;
var from_am, to_am;
var from_hr,from_mn,to_hr,to_mn;
var user_id;
var worker = null;
var data = {};
var mapMarkers = {};
var currentPos = {};
var type;
var device_id;
var is_play = true;
var circle;
var dirService, renderer;
var marker;
var polyline, distance;
var animator;
var travel_time = [];
var INC=0;
var post_lock_state=true;

var places = [
    {lat: 23.797251, lng: 90.401509}
];
var init_pos = [
    {lat: 23.797251, lng: 90.401509}
];
function makeMarker(id, pos) {
      if(marker)
      {
      marker.setMap(null);
      marker=null;
      }
    return new google.maps.Marker({
        position: pos,
        title: 'location History tracking',
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
        //console.log(data);
    }
}

function convertToLatLng(pos) {
    return new google.maps.LatLng(pos.lat, pos.lng);
}

function getNextPos(k) {
    var val = currentPos[k];
  //  console.log(val);
    if (val < data[k].length - 1) {
        return convertToLatLng(data[k][val]);
    }
    return null;
}

function toggleForm(state) {
   $('input[name="type"]').val(state ? 1 : 0);
   type = $('input[name="type"]').val();
    if (!state) {
        $('#sub-form').css('display', 'block');
    } else {
        $('#sub-form').css('display', 'none');
    }
}

function getNextHeading(k) {

    var val = currentPos[k];
  //  console.log(val);
    if (val < data[k].length - 1) {
      INC++;
      console.log(data[k][INC]);
      $("#map_time").html(data[k][INC].when);

        return google.maps.geometry.spherical.computeHeading(
            convertToLatLng(data[k][val]),
            convertToLatLng(data[k][val+1])
        );
    }
    return null;
}

function updateMap() {

    for(var k in mapMarkers) {
       //console.log(data[k]);
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

        if (inc == true) {
              currentPos[k]++;
            //  $("#map_time").html(data[k][1].when);

        }


    }

      worker = setTimeout(updateMap,500);

}

function fetchHistory() {
    page++;
    var url = '/tracking/records/fetch'
        + '?from_hr=' + from_hr
        + '&to_hr=' + to_hr
        + '&from_mn=' + from_mn
        + '&from_am=' + from_am
        + '&to_am=' + to_am
        + '&to_mn=' + to_mn
        + '&date=' + date
       + '&page=' + page
        + '&id=' + user_id
        + '&type='+type;

  // console.log(url);

    $.get(url, function(response) {

        //var Result= [];
        var counter = 0;
        console.log(response);
        var repeat = false;
        if (response.status == 1) {
        places = [];
        for (var k in response.data) {
        //  travel_time[k]
          if (response.data[k].length > 0) {
            for (var i in response.data[k]) {
              //console.log(response.data[k][i].when);
              travel_time.push(response.data[k][i].when);

            //  places.push({lat:response.data[k][i].lat,lng:response.data[k][i].lng,when:response.data[k][i].when});
            }
                    repeat = true;
                    if (!mapMarkers.hasOwnProperty(k)) {
                        initCar(k, response.data[k]);
                    } else {
                        appendData(k, response.data[k]);
                    }
                 }
             }
             //console.log(places);

            if (worker == null) {
                worker = setTimeout(updateMap, 0);

            }

            if (repeat == true) {

                fetchHistory();
            }

        }
      //   checkForFirst();//using initial location for once only
      //   if(!marker)
      //   {
      //   marker = new google.maps.Marker({
      //       position: {lat:Number(places[0].lat),lng:Number(places[0].lng)},
      //       title: 'Hyper Systems Ltd.',
      //       map: map,
      //       draggable:true,
      //       icon: icon,
      //       duration: 1000,
      //   });
      // }


    });
}

function PastDataWiseDisplay(dirService, renderer, way,pointA, pointB) {
    var pointsArray = [];
  dirService.route({
      origin: pointA,
      destination: pointB ,
      travelMode: google.maps.DirectionsTravelMode.DRIVING,
      waypoints: way

  }, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
         renderer.setDirections(response);
          var bound = new google.maps.LatLngBounds();
          console.log(bound);
          var route = response.routes[0];
          console.log(route);
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
          console.log(pointsArray);
      }
  });
}
function changePos(i) {
  console.log(i);
  console.log(distance);

  if(distance<=20)
    {
      console.log(distance+'m--Less than 20m distance.car was not moved');
      return
    }
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
        console.log(marker.getPosition());
        //marker.getMap().panTo(marker.getPosition());
        //
        // var point = marker.getMap().getCenter();
        // animator.easeProp({
        //     lat: point.lat(),
        //     lng: point.lng(),
        // }, places[i]);
    }

    marker.setPosition(new google.maps.LatLng(places[i].lat, places[i].lng));

    setTimeout('changePos('+(i+1)+')', 1000);
}
function animate(d) {
 var in_or_out_map =   inBound(marker);
 //console.log(d);
    if (d > distance) {
        var end = getEndLocation();
        console.log("end: ", distance);
        map.panTo(end);
        marker.setPosition(end);
        return;
    }

    var p = polyline.GetPointAtDistance(d);
    var lastPosn = marker.getPosition();

    if(in_or_out_map==false)
    {

    //  alert('aaaaaaaaaaaaa');
      //bounds.extend();
      //  map.setCenter(bounds.getCenter());
      //map.fitBounds(bounds)
      //  map.panTo(bounds.getCenter());
    }
    //map.fitBounds(bounds);
     marker.setPosition(p);
    var heading = google.maps.geometry.spherical.computeHeading(lastPosn, p);
    var icon = marker.getIcon();
    icon.rotation = heading;
    marker.setIcon(icon);

    timerHandle = setTimeout("animate(" + (d+3)+ ")", 500);
}

function animate_live(d) {
   var in_or_out_map =   inBound(marker);
   if(distance<=20)
    {
      console.log(distance+'m--Less than 20m distance.car was not moved');
      return
    }

    if (d > distance) {
        var end = getEndLocation();
        console.log("end: ", distance);
        map.panTo(end);
        marker.setPosition(end);
        return;
    }

     var p = polyline.GetPointAtDistance(d);
     var lastPosn = marker.getPosition();
     marker.setPosition(p);
     var heading = google.maps.geometry.spherical.computeHeading(lastPosn, p);
     var icon = marker.getIcon();
    icon.rotation = heading;
    marker.setIcon(icon);

    timerHandle = setTimeout("animate(" + (d+2.8)+ ")", 10000);
}

function startHistoryFetching() {
    removeHistoryCache();

    date = $("#date").val();
    from_hr = $('#from_hr').val();
    from_mn = $('#from_mn').val();
    from_am = $('#from_am').val();
    to_am = $('#to_am').val();
    to_hr = $('#to_hr').val();
    to_mn = $('#to_mn').val();
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
    marker = null;//@latest
}

function initMapV2() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        center: new google.maps.LatLng(23.776750, 90.396653),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    animator = EasingAnimator.makeFromCallback(function(latLng){
        //console.log("changing center: ", latLng);
        map.setCenter(latLng)
    });

    dirService = new google.maps.DirectionsService();
    renderer = new google.maps.DirectionsRenderer({
        map: map,
        preserveViewport: true,
    });
    google.maps.event.addListenerOnce(map, 'idle', function(){
        // fetchCars();
        //  bounds = map.getBounds();
        //   se_lat =bounds.getSouthWest().lat();
        //   se_lng = bounds.getSouthWest().lng();
        //   ne_lat = bounds.getNorthEast().lat();
        //   ne_lng = bounds.getNorthEast().lng();


    });
}

function inBound(marker){
  return map.getBounds().contains(marker.getPosition());
}
function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          mapMarkers[i].setMap(map);
        }
      }
      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }
      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        mapMarkers = {};
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


function isBoundaryCrossed() {


}


function initMap() {
       pos = new google.maps.LatLng(places[0].lat, places[0].lng);
       map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        center: pos,
        mapTypeId: google.maps.MapTypeId.ROADMAP,

    });
    //console.log(pos);
    animator = EasingAnimator.makeFromCallback(function(latLng){
        //console.log("changing center: ", latLng);
        map.setCenter(latLng)
    });

    marker = new google.maps.Marker({
        position: pos,
        title: 'Hyper Systems Ltd.',
        map: map,
        icon: icon,
        duration: 1000,
    });
    google.maps.event.addListenerOnce(map, 'idle', function(bound){

    });
}
$(function() {

    user_id = $('input[name="user_id"]').val();
    $("#map_time").html("");
    var current_time =moment().format('MMMM Do YYYY, h:mm:ss');
    $("#map_time").html(current_time);
    $("[name='toggle']").bootstrapSwitch();
    $("[name='toggle_car']").bootstrapSwitch();
    var lock_status =null;
    var engine_status =null;
   $("[name='toggle_car']").data('is_get','0');

//setting up intital state of Car
    $.get("/api/getState/"+user_id, function(data, status){
       //state true means locked
       //state false means unlocked

       $("[name='toggle_car']").data('is_get','1');

          lock_status = parseInt(data.lock_status);
          engine_status = parseInt(data.engine_status);
          if(engine_status==1)
             {
               $("#engine_status_alert").html("");
               $("#engine_status_alert").html("Engine ON ");

             }
            else if (engine_status==0) {
              $("#engine_status_alert").html("");
              $("#engine_status_alert").html("Engine OFF ");
            }

          if(lock_status==1)
          {
            $("[name='toggle_car']").bootstrapSwitch('state', true);
          }
          else if (lock_status==0) {
            $("[name='toggle_car']").bootstrapSwitch('state', false);
          }


      });

    var state = $('input[name="toggle"]').bootstrapSwitch('state');
    toggleForm(state);
    initMapV2();

    $('input[name="toggle"]').on('switchChange.bootstrapSwitch', function(event, state) {
       toggleForm(state);
         if(state ==false)
         {
           initMap();
           unsubscribe_channel('map-channel-'+user_id);

         }
         else{
            console.log('live');
            location.reload();
            subscribe_channel('map-channel-'+user_id);
         }

    });

    $('#date').datepicker({
         }).on('change', function(e){
             $(this).datepicker('hide');
         });

             var i;
             for(i = 1; i <= 12; i++) {
                 $('.hour').append($('<option>', { value: i < 10 ? '0' + i : i, text: i, }));
             }

             for(i = 0; i <= 59; i++) {
                 $('.mint').append($('<option>', { value: i < 10 ? '0' + i : i, text: i, }));
             }

             $('.am').append($('<option>', { value: 'am', text: 'AM', }));
             $('.am').append($('<option>', { value: 'pm', text: 'PM', }));

          //  initMap();
            $('#filter').click(function() {
                INC = 0;
                initMapV2();
                startHistoryFetching();
            })


});

</script>
<script>

$('input[name="toggle_car"]').on('switchChange.bootstrapSwitch', function(event, state) {
  console.log(state);
  console.log(event);
  if($(this).data("is_get")=='1')
   {
     $(this).data('is_get','0');
     return;

   }

  var lock_state;
    if(state==false)
     {
        lock_state = 0; //unlock
     }
     else if (state==true) {
        lock_state =1; //lock
     }

  $.post("/api/toggleEngine",
     {
         'user_id': user_id,
         'lock_status':lock_state

     },
     function(response, status){
         var msg = response.message;

         console.log(response.data);
         if(response.data.lock_status==1)
         {
           $("[name='toggle_car']").bootstrapSwitch('state', true);
         }
         else if (response.data.lock_status==0) {
           $("[name='toggle_car']").bootstrapSwitch('state', false);
         }

         if(response.data.engine_status==1)
            {
              $("#engine_status_alert").html("");
              $("#engine_status_alert").html("Engine  ON ");

            }
           else if (response.data.engine_status==0) {
             $("#engine_status_alert").html("");
             $("#engine_status_alert").html("Engine  OFF ");
           }
           alert(msg);
     });

});


</script>


<script>

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
</script>
<script>
var pusher = new Pusher('e104f912331445995538', {
cluster: 'ap1',
encrypted: false
});
 var state = pusher.connection.state;
 var user_id = $('input[name="user_id"]').val();

 console.log(user_id);

 var channel = pusher.subscribe('map-channel-'+user_id);

 function unsubscribe_channel(channelName) {
    pusher.unsubscribe(channelName);
  }

  function subscribe_channel(channelName ) {
    pusher.subscribe(channelName);
  }
  var doneTheStuff;
  function checkForFirst() {
   if (!doneTheStuff) {
       places.shift()//removing 1st array from object ->places
       doneTheStuff = true;
   }
 }
 polyline = new google.maps.Polyline({
    path: [],
    strokeColor: '#57F2F7',
    strokeWeight: 3,
});


channel.bind('engine-event', function(data) {
  if(data.message.engine_status==0)
    {
      console.log(data.message.engine_status)
      $("#engine_status_alert").html("");
      $("#engine_status_alert").html("Engine OFF");
      alert("Engine OFF");
    }


});
channel.bind('map-event', function(data) {

  $("#map_time").html('');
  var time_show_in_map =  moment(data.message.LatLng[2]).format('MMMM Do YYYY, h:mm:ss a');
  $("#map_time").html(time_show_in_map);
  checkForFirst();//using initial location for once only
  if(!marker)
  {
  marker = new google.maps.Marker({
      position: {lat:Number(data.message.LatLng[0]),lng:Number(data.message.LatLng[1])},
      title: 'Hyper Systems Ltd.',
      map: map,
      icon: icon,
      duration: 1000,


  });
 }
  places.push({lat:Number(data.message.LatLng[0]),lng:Number(data.message.LatLng[1]),when:data.message.LatLng[2]});

  places.splice(0, places.length - 2);
  var way = [];
  for (var i = 1; i < places.length - 1; i++) {
     way.push({
         location: new google.maps.LatLng(places[i].lat, places[i].lng),
         stopover: false,
     });
 }

 var st = new google.maps.LatLng(places[0].lat, places[0].lng);
 //console.log(st);
 var en = new google.maps.LatLng(places[1].lat, places[1].lng);
 //interval_taken =
 if(places[0].lat ==places[1].lat &&  places[0].lng ==places[1].lng)
  {
    console.log(marker);
    //marker.setPosition(new google.maps.LatLng(23.794054, 90.402967));
    //console.log(places[places.length - 1].lat,places[places.length - 1].lng);
    //console.log(places[0].lat,places[0].lng);
    var LAT = places[0].lat;
    var LNG = places[0].lng;

    console.log(LAT);
    console.log(LNG);

    marker.setMap(null);
    marker=null;
    marker = new google.maps.Marker({
        position: {lat:LAT,lng:LNG},
        title: 'Hyper Systems Ltd',
        map: map,
        icon: icon,
        duration: 1000,
    });
    console.log("Car won't move");
    return
  }
 //console.log(en);
 dirService.route({
     origin: st,
     destination: en ,
     travelMode: google.maps.DirectionsTravelMode.DRIVING,
     waypoints: way

 }, function(response, status) {
     if (status == google.maps.DirectionsStatus.OK) {
        time_1 =  moment(places[0].when).format('MMMM Do YYYY, h:mm:ss a');
        time_2 =  moment(places[places.length -1].when).format('MMMM Do YYYY, h:mm:ss a');
        console.log(time_1) ;
        console.log(time_2);
        var time_diff = moment(time_1,"MMMM Do YYYY, h:mm:ss a").diff(moment(time_2,"MMMM Do YYYY, h:mm:ss a"));
        var time_diff_duration = moment.duration(time_diff);
        interval_taken = Math.abs(time_diff_duration.seconds());
        console.log(interval_taken);
       //console.log(d.days(), d.hours(), d.minutes(), d.seconds());
        renderer.setDirections(response);
         var bound = new google.maps.LatLngBounds();
         console.log(bound);
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
         animate_live(1);

     }
 });
console.log(places);
});
</script>
@endsection
