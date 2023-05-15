
@extends('layouts.app')

@section('content')

<div>
    <label><h3>Assigned Services </h3></label>

<br><br><br>
@if(isset($all_services))
@foreach($all_services as $key => $value)
<h5>{{$value}}<h5>
    <input type="hidden" id="user_id" name="user_id" value="{{Request::segment(3)}}">
    <input type="checkbox" class='checkbox-services' data-toggle="toggle" id = "{{$key}}" value = "{{$key}}"
   @if(isset($data))
    @if (in_array($key, json_decode($data,true)))
        checked
     @endif
    @endif>
  <br><br><br><br>
@endforeach
@endif


@endsection

@section('js')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
$(document).ready(function(){
$('.checkbox-services').on('change', function () {
  var STATUS;
  var user = $("#user_id").val();
  if ($(this).is(':checked')) {
   STATUS = 1;
  }
  else{
    STATUS = 0;

   }
    var value = $(this).val();
    $.ajax({
        type: "POST",
        url: "/services/api/update",
        async: true,
        data: {
            sid: value,
            status: STATUS,
            user_id:user
        },
        success: function (response) {
            alert(response.msg);
            location.reload();
        }
    });
});

});
</script>
@endsection
