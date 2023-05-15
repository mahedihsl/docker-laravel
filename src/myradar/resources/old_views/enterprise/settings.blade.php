@extends('layouts.new')

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <style>
  .btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}

  </style>
@endpush
@section('title')
  Settings
@endsection

@section('content')
  <div  id="app">
      <button type="button" title="Stop Notification from this site!" onclick="UnsubscribeOneSignal()" id="unsubscribe" style="display:none;margin-bottom:10px; "class="btn btn-warning btn-circle pull-right"><i class="glyphicon glyphicon-remove"></i></button>
      <button type="button" title="Subscribe for Notification!" onclick="subscribeOneSignal()" id="subscribe" style="display:none;margin-bottom:10px;" class="btn btn-info btn-circle pull-right"><i class="glyphicon glyphicon-ok"></i></button>
      <input type="hidden" name="user_id" value="{{$userId}}">

      <select-car> </select-car>
      <settings-list v-bind="props"> </settings-list>

      <fence> </fence>


  </div>
@endsection
@push('script')
  <script src="{{ asset('js/enterprise/settings.js', true) }}" charset="utf-8"></script>
  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script type="text/javascript">
    $(function() {
      $('div.box-header').css('background', '#00994D').css('color', '#ffffff');
    });
  </script>
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
