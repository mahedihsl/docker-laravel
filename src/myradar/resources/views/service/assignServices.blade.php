
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Assign Services
            </div>

            <div class="panel-body">
                <form class="form" action="/customer/services/saveServiceswithComId" method="post" id ="form-service" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <input type="text"  name="com_id" class="form-control" placeholder="Type Commercial ID" required="true">
                  <input type="hidden" name="user_id" value="{{Request::segment(4)}}">
                @if(isset($all_services))
                    @foreach($all_services as $key => $value)
                    <h5>{{$value}}<h5>
                        <input type="checkbox" class='checkbox-services' name ="selected[]" data-toggle="toggle" id = "{{$key}}" value = "{{$key}}"

                      <br><br><br><br>
                    @endforeach
               @endif
                      <br><br><br>
                    <button type="submit" id="submit-form" class="btn btn-success btn-sm">
                        <i class="fa fa-save"></i> SAVE
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
$(document).ready(function(){
// $('.checkbox-services').on('change', function () {
//   var STATUS;
//   var user = $("#user_id").val();
//   if ($(this).is(':checked')) {
//    STATUS = 1;
//   }
//   else{
//     STATUS = 0;
//
//    }
//     var value = $(this).val();
//     $.ajax({
//         type: "POST",
//         url: "/services/api/update",
//         async: true,
//         data: {
//             sid: value,
//             status: STATUS,
//             user_id:user
//         },
//         success: function (msg) {
//             alert('Success');
//         }
//     });
// });

$('#submit-form').on('click', function (event) {

//console.log($("#form-service .checkbox-services:checked").length);

  if($("#form-service .checkbox-services:checked").length == 0)
   {
    event.preventDefault();
    return alert("Please Select Service");

   }

     });
  });
</script>
@endsection
