@extends('layouts.enterprise_customer')
  @section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
  @endsection

  @section('content')
      <div class="row">
          <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">
                      Mileage Report
                      <input type="hidden" name="userid" value="{{$user->id}}">
                  </h3>
                </div>
                <div class="panel-body">
                   @include('enterprise.mileage.comp.search_filter', ['data' => ''])
<br><br>
        <table  id="myTable" class="table table-striped table-bordered table-hover table-responsive">
                <thead>

                   <th>Car Reg No.</th>
                    <th>Driver</th>
                    <th>Owner Name.</th>
                    <th>Owner Phone</th>
                    <th>Total Mileage (KM)</th>
                    <th>Daywise</th>

                </thead>
                 <tbody>
                   <div id="no_data_found"></div>
                 @if(!empty($mileage))
                     @foreach ($mileage as $mileage)
                     <tr>
                       <td>{{$mileage['car_no']}}</td>
                       <td>{{$mileage['driver_name']}}</td>
                       <td>{{$mileage['owner_name']}}</td>
                       <td>{{$mileage['owner_phone']}}</td>
                       <td>{{$mileage['mileage']}}</td>
                       <td><input class="btn btn-sm btn-primary show-day-wise-mileage"
                         type="button" name="car_id"
                          value="view"
                          data-car-id="{{$mileage['car_id']}}"
                          data-car-reg-no="{{$mileage['car_no']}}"
                          data-owner-name="{{$mileage['owner_name']}}"
                          data-car-driver-name="{{$mileage['driver_name']}}"
                      <i class="fa fa-eye"></i>
                    </button>
                       </td>
                     </tr>
                     @endforeach
                    @endif

                 @include('enterprise.mileage.modal.day_wise_mileage')
               </tbody>
                 </table>
                 </div>
                <div class="panel-footer">

                </div>
              </div>
          </div>
      </div>
  @endsection

  @section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
  <script>
 $(function(){
   var car_id;
   var bar_chart;
  $('#date_range_selection').select2();
   var chart_title = "Mileage of Last 30 days"
   $('.modal-close').on('click',function (e) {

    });
    $('.show-day-wise-mileage').on('click',function (e) {
        car_id = $(this).data('car-id');
        $("#day_wise_mileage_modal_title").html('<h3 style="color:green">Mileage Report of Last 30 Days</h3>')
        $("#day_wise_mileage_modal_owner_name").html("<i class='fa fa-user-o fa-1x' style='color:green'></i> Owner : "+$(this).data('owner-name'));
        $("#day_wise_mileage_modal_car_reg_no").html("<i class='fa fa-car fa-1x' style='color:green'></i> Reg No. : "+$(this).data('car-reg-no'));
        $("#day_wise_mileage_modal_car_driver_name").html("<i class='fa fa-user-circle fa-1x' style='color:green'></i> Driver : "+$(this).data('car-driver-name'));
        $("#day_wise_mileage_modal").modal('show');
        $.getJSON("/mileage/records/"+car_id+"/30", function(result){
             if(result.status==1)
                 response = result.data.items;
                 renderChart(response);
         });

     });
     $("#date_range_selection").change(function(){
       var value = $(this).val();
       $.getJSON("/mileage/records/"+car_id+"/"+value, function(result){
            if(result.status==1)
            $("#day_wise_mileage_modal_title").html('<h3 style="color:green">Mileage Report of Last '+value+' Days </h3>')
                response = result.data.items;
                renderChart(response);
        });

     });

 });
  </script>

  <script>
   var bar_chart =null
  function getLabels(response) {
    return response.map(function(item) {
      return item.date;
    });
  }

  function getData(response) {
    return response.map(function(item) {

      return item.value;
    });
  }

  function renderChart(response)
   {
     if(bar_chart!=null){
             bar_chart.destroy();
         }
     var ctx = document.getElementById("bar_chart_mileage").getContext('2d');
      bar_chart = new Chart(ctx, {
     type: 'bar',
     data: {
         labels: getLabels(response),
         datasets: [{
             label: 'Mileage(KM)',
             data: getData(response),
             backgroundColor: "blue",
             borderColor:"white",
             borderWidth: 5
         }]
     },
     options: {
         scales: {
             yAxes: [{
                 scaleLabel: {
                  display: true,
                  labelString: 'Mileage (KM)'
                }
             }
           ],
           xAxes: [{
               scaleLabel: {
                display: true,
                labelString: 'Date'
              }
           }
         ]

         }
     }
   });
   }

  </script>
  @endsection
