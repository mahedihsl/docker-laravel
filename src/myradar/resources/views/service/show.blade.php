@extends('layouts.new')

@push('style')
<style media="screen">
    .info-boxx {
        background: white;
        border-radius: 4px;
        min-height: 260px;
        margin-top: 20px;
        border: 1px solid #E0E0E0;
        border-top: 3px solid #4CAF50;
        box-shadow: 0 3px 6px rgba(0,0,0,0.10), 0 6px 12px rgba(0,0,0,0.16);
    }
    .info-boxx .box-title {
        font-size: 15px;
        font-weight: bold;
        color: #616161;
        padding: 6px 0;
    }
    .info-boxx > .content {
        width: 100%;
        height: auto;
        margin: auto;
        display: block;
    }
    .info-boxx .full-width {
        width: 100%;
        display: block;
    }
    .text-main {
        font-size: 16px;
        font-weight: bold;
        /*color: #212121;*/
    }
    .icon-main {
        display: block;
        margin: 20px auto;
        width: 60px;
        height: 60px;
    }
    .btn-action {
        background: white;
        border-radius: 5px;
        display: block;
        margin: 15px auto;
    }
    .action-blue {
        border: 1px solid #2196F3;
        color: #1976D2;
    }
    .action-blue:hover {
        background: #EEEEEE;
        border: 1px solid #2196F3;
        color: #1976D2;
    }
    .action-green {
        border: 1px solid #4CAF50;
        color: #388E3C;
    }
    .action-orange {
        border: 1px solid #FF9800;
        color: #F57C00;
    }
    .action-purple {
        border: 1px solid #9C27B0;
        color: #7B1FA2;
    }
    .btn-purple:hover {
        color: white;
        background: #9C27B0;
        border: 1px solid #7B1FA2;
    }
    .btn-orange:hover {
        color: white;
        background: #FF9800;
        border: 1px solid #F57C00;
    }
    .btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
  }
    .chart-box {
        width: 100%;
        display: block;
        margin: 15px auto;
    }
    .raw-canvas {
        display: block;
        margin: 0 auto;
    }
    .v-space {
        margin: 20px 0;
    }
    .large-box {
        min-height: 300px;
    }

    .select-style {
        margin-top: 10px;
        border: 1px solid #ccc;
        width: 120px;
        border-radius: 3px;
        overflow: hidden;
        background: #fafafa url("data:image/png;base64,R0lGODlhDwAUAIABAAAAAP///yH5BAEAAAEALAAAAAAPABQAAAIXjI+py+0Po5wH2HsXzmw//lHiSJZmUAAAOw==") no-repeat 90% 50%;
    }

    .select-style select {
        cursor: pointer;
        padding: 5px 8px;
        width: 130%;
        border: none;
        box-shadow: none;
        background: transparent;
        background-image: none;
        -webkit-appearance: none;
    }

    .select-style select:focus {
        outline: none;
    }
</style>
@endpush

@section('content')
  <input type="hidden" name="user_id" value="{{$user_id}}">
  <input type="hidden" name="car_id" value="{{$car_id}}">
  <input type="hidden" name="device_id" value="{{$device_id}}">

  <div id="app">

    <button type="button" title="Stop Notification from this site!" onclick="UnsubscribeOneSignal()" id="unsubscribe" style="display:none;margin-bottom:10px; "class="btn btn-warning btn-circle pull-right"><i class="glyphicon glyphicon-remove"></i></button>
    <button type="button" title="Subscribe for Notification!" onclick="subscribeOneSignal()" id="subscribe" style="display:none;margin-bottom:10px;" class="btn btn-info btn-circle pull-right"><i class="glyphicon glyphicon-ok"></i></button>

    <switcher :user-id="userId"></switcher>
    <loader v-if="loading"></loader>
    <div class="row" v-if="!!car">
      <engine :reg-no="car.reg_no" :device-id="car.device_id" :subscribed="engine"></engine>
      {{-- <fuel :device-id="car.device_id" :subscribed="fuel"></fuel> --}}
      <gas :device-id="car.device_id" :subscribed="gas"></gas>
    </div>
    <div class="row" v-if="!!car">
      {{-- <fuel-chart :device-id="car.device_id" :subscribed="fuel"></fuel-chart> --}}
      <gas-view :reg-no="car.reg_no" :device-id="car.device_id" :subscribed="gas"></gas-view>
      <mileage :car-id="car.id" :subscribed="mileage"></mileage>
    </div>
  </div>
@endsection

@push('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js" charset="utf-8"></script>
  <script src="{{ asset('js/customer/service.js', true) }}" charset="utf-8"></script>
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
  <script type="text/javascript">
      var OneSignal = window.OneSignal || [];
      OneSignal.push(function(){
        OneSignal.init({
          appId: "b3006f06-ab37-4377-8406-776d35ef75fe",
          autoRegister: false,
        });
      });

      OneSignal.push(["getNotificationPermission", function(permission) {
        console.log("status ",permission);
        if(permission == "granted"){
          OneSignal.getUserId().then(function(userId) {
              useragentid = userId;
          }).then(function(){
              if(!useragentid){
                OneSignal.showHttpPrompt({force:true});
              }
              else{
                var user_id = $('input[name="user_id"]').val();
                var token   = "{{ csrf_token() }}";
                var subscriptionResponse = null;
                $.post("/check/subscription", {
                    'user_id': user_id,
                    'type': 2,
                    '_token': token,
                    'new': useragentid,
                },function(response){
                  console.log("response data is",response);
                  subscriptionResponse = response.data.message;
                }).then(function(){
                    console.log(subscriptionResponse);
                    if(subscriptionResponse){
                      document.getElementById('subscribe').style.display = 'none';
                      document.getElementById('unsubscribe').style.display = '';
                    }
                    else{
                      document.getElementById('subscribe').style.display = '';
                      document.getElementById('unsubscribe').style.display = 'none';
                    }
                });
              }

          })
        }
        else{
          OneSignal.showHttpPrompt({force:true});
          document.getElementById('unsubscribe').style.display = 'none';
          document.getElementById('subscribe').style.display = 'none';
        }

      }]);


      function UnsubscribeOneSignal(){
        OneSignal.push(["getNotificationPermission", function(permission) {
          console.log("status ",permission);
          if(permission == "granted"){
            OneSignal.getUserId().then(function(userId) {
                useragentid = userId;
            }).then(function(){
                  var user_id = $('input[name="user_id"]').val();
                  var token   = "{{ csrf_token() }}";
                  var httpResponse = null;
                  $.post("/bind/token", {
                      'user_id': user_id,
                      'type': 2,
                      '_token': token,
                      'old': useragentid,
                  },function(response){
                    httpResponse = response.status;
                  }).then(function(){
                      if(httpResponse)
                      {
                        document.getElementById('unsubscribe').style.display = 'none';
                        document.getElementById('subscribe').style.display = '';
                      }
                  });
            });
          }


        }]);
      }

        function subscribeOneSignal(){

          OneSignal.getUserId().then(function(userId) {
              useragentid = userId;
          }).then(function(){
              var user_id = $('input[name="user_id"]').val();
              var token   = "{{ csrf_token() }}";
              var httpResponse = null;
              $.post("/bind/token", {
                  'user_id': user_id,
                  'type': 2,
                  '_token': token,
                  'new': useragentid,
              },function(response){
                httpResponse = response;
              }).then(function(){
                if(httpResponse){
                  document.getElementById('unsubscribe').style.display = '';
                  document.getElementById('subscribe').style.display = 'none';
                }
              });
          });
        }

        OneSignal.push(function() {
            OneSignal.on('subscriptionChange', function (isSubscribed) {
                if(isSubscribed==true){
                    OneSignal.getUserId().then(function(userId) {
                        useragentid = userId;
                    }).then(function(){
                        var user_id = $('input[name="user_id"]').val();
                        var token   = "{{ csrf_token() }}";
                        $.post("/bind/token", {
                            'user_id': user_id,
                            'type': 2,
                            '_token': token,
                            'new': useragentid,
                        });
                    });
                    document.getElementById('unsubscribe').style.display = '';
                }
                else if(isSubscribed==false){
                    OneSignal.getUserId().then(function(userId) {
                        useragentid = userId;
                    }).then(function(){
                        var user_id = $('input[name="user_id"]').val();
                        var token   = "{{ csrf_token() }}";
                        $.post("/bind/token", {
                            'user_id': user_id,
                            'type': 2,
                            '_token': token,
                            'old': useragentid,
                        });
                    });
                }
                else{
                    console.log('Unable to process the request');
                }
            });
          });

  </script>
@endpush
