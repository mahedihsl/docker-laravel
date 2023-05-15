
@extends('layouts.custom')
@section('content')
<br><br><br><br>
@if(Session::has('flash'))
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert">×</a>
            <strong>Congrats!!!</strong> {!!Session::get('flash')!!}
        </div>
    @endif

<form id="form-forget-pass" role="form" method="POST" action="" novalidate class="form-horizontal">
  <div class="col-md-9">
       <h2><div id="msg"></div></h2>
    <label for="username" class="col-sm-4 control-label"></label>

    <div class="col-sm-8">
      <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="text" class="form-control" id="username" name="username" placeholder="Email or Phone">
         <div id="errorMsg"></div>
         <div id="loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>

      </div>
    </div>

  </div>
  <div class="form-group">
    <div class="col-sm-offset-5 col-sm-6">
      <button type="button" class="btn btn-success" id="sendResetCode">Submit</button>
     <br><br><br>

    </div>
  </div>
</form>
@endsection
@section('js')
<script>
$(document).ready(function() {
$("#loading").hide();
  $(document).ajaxStart(function () {
        $("#loading").show();
    }).ajaxStop(function () {
        $("#loading").hide();
    });

  $("#errorMsg").html("");
  $('#sendResetCode').prop('disabled', true);
    $("#username").keyup(function() {
        var username = $("#username").val();
        if (username == '') {
            return $("#errorMsg").html("Please provide E-mail or Phone");

        } else {

            var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            var phone = /(^(\+88|0088)?(01){1}[56789]{1}(\d){8})$/;
            if (testEmail.test(username))
            {
              $('#sendResetCode').prop('disabled', false);
             $("#errorMsg").html("");
            }
            else if (phone.test(username)) {
              $('#sendResetCode').prop('disabled', false);
                $("#errorMsg").html("");

            } else {
              $('#sendResetCode').prop('disabled', true);
                return $("#errorMsg").html("Username should be valid E-mail or phone number");

            }

        }

    });

});


  $("#sendResetCode").click(function() {

       $("#msg").html("");
       var username = $("#username").val();
       if (username == '') {
           return $("#errorMsg").html("Please provide E-mail or Phone");

       } else {

           var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
           var phone = /(^(\+88|0088)?(01){1}[56789]{1}(\d){8})$/;
           if (testEmail.test(username))
           {
             $('#sendResetCode').prop('disabled', false);
            $("#errorMsg").html("");
            $.post("/api/sendVerificationCode", {'username':username}, function(result){
                $("#msg").html(result.message);
                $("#username").val("");

           });
           }
           else if (phone.test(username)) {
             $('#sendResetCode').prop('disabled', false);
               $("#errorMsg").html("");
               $.post("/api/sendVerificationCode", {'username':username}, function(result){
                   $("#msg").html(result.message);
                   $("#username").val("");

             });

           } else {
             $('#sendResetCode').prop('disabled', true);
               return $("#errorMsg").html("Username should be valid E-mail or phone number");

           }

       }

  });

</script>
@endsection
