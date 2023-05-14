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
                      Drving Hour Report
                      <input type="hidden" name="userid" value="{{$user->id}}">
                  </h3>
                </div>
                <div class="panel-body">

                   @include('enterprise.driving_hour.comp.search_filter', ['data' => ''])
<br><br>
        <table  id="myTable" class="table table-striped table-bordered table-hover table-responsive">
                <thead>

                   <th>Car Reg No.</th>
                    <th>Driver</th>
                    <th>Owner Name.</th>
                    <th>Owner Phone</th>
                    <th>Total Driving Hour</th>
                    <th>Daywise</th>

                </thead>
                 <tbody>
                   <div id="no_data_found"></div>
                 @if(!empty($driving_hour))
                     @foreach ($driving_hour as $driving_hour)
                     <tr>
                       <td>{{$driving_hour['car_no']}}</td>
                       <td>{{$driving_hour['driver_name']}}</td>
                       <td>{{$driving_hour['owner_name']}}</td>
                       <td>{{$driving_hour['owner_phone']}}</td>
                       <td>{{$driving_hour['total_driving_hour']}}</td>
                       <td><input class="btn btn-sm btn-primary show-day-wise-driving-hour"
                         type="button" name="car_id"
                          value="view"
                          data-car-id="{{$driving_hour['car_id']}}"
                          data-car-reg-no="{{$driving_hour['car_no']}}"
                          data-owner-name="{{$driving_hour['owner_name']}}"
                          data-car-driver-name="{{$driving_hour['driver_name']}}"
                      <i class="fa fa-eye"></i>
                    </button>
                       </td>
                     </tr>
                     @endforeach
                    @endif

                 @include('enterprise.driving_hour.modal.day_wise_driving_hour')
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
   $("#date_range_selection").select2({});
   var car_id;
   var bar_chart;
   var chart_title = "Driving Hour of Last 30 days"
   $('.modal-close').on('click',function (e) {

    });
    $('.show-day-wise-driving-hour').on('click',function (e) {
        car_id = $(this).data('car-id');

        $("#day_wise_driving_hour_modal_title").html('<h3 style="color:magenta">Driving Hour Report of Last 30 Days</h3>')
        $("#day_wise_driving_modal_owner_name").html("<i class='fa fa-user-o fa-1x' style='color:green'></i> Owner : "+$(this).data('owner-name'));
        $("#day_wise_driving_modal_car_reg_no").html("<i class='fa fa-car fa-1x' style='color:green'></i> Reg No. : "+$(this).data('car-reg-no'));
        $("#day_wise_driving_modal_car_driver_name").html("<i class='fa fa-user-circle fa-1x' style='color:green'></i> Driver : "+$(this).data('car-driver-name'));
        $("#day_wise_driving_modal").modal('show');
        $.getJSON("/enterprise/driving/records/"+car_id+"/30", function(result){
             if(result.status==1)
                 response = result.data.items;
                 renderChart(response);
         });

     });

     $("#date_range_selection").change(function(){
       var value = $(this).val();
       $.getJSON("/enterprise/driving/records/"+car_id+"/"+value, function(result){
            if(result.status==1)
            $("#day_wise_driving_hour_modal_title").html('<h3 style="color:magenta">Driving Hour Report of Last '+value+' Days </h3>')
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
     var ctx = document.getElementById("bar_chart_driving_hour").getContext('2d');
      bar_chart = new Chart(ctx, {
     type: 'bar',
     data: {
         labels: getLabels(response),
         datasets: [{
             label: '',
             data: getData(response),
             backgroundColor: "green",
             //borderColor:"white",
             borderWidth: 5
         }]
     },
     options: {
         scales: {
             yAxes: [{
                 scaleLabel: {
                  display: true,
                  labelString: 'Driving Hour'
                },
                gridLines: { display: false }
             }
           ],
           xAxes: [{
               scaleLabel: {
                display: true,
                labelString: 'Date'
              },
              gridLines: { display: true },
              barThickness:20
           }
         ]

         }
     }
   });
   }

  </script>
  @endsection
