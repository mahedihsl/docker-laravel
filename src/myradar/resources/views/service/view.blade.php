
@extends('layouts.private_customer')
<style>
hr.style5 {
	background-color: #fff;
	border-top: 2px dashed #8c8b8b;
}

#gas_level5{
    width:30px;
    height:50px;
    background:green
}
#gas_level4{
    width:30px;
    height:50px;
    background:green
}

#gas_level3{
    width:30px;
    height:50px;
    background:green
}

#gas_level2{
    width:30px;
    height:50px;
    background:green
}

#gas_level1{
    width:30px;
    height:60px;
    background:yellow
}

#unlock_button{
   border-radius: 0;

 }
 #lock_button{
    border-radius: 0;

  }
  #unlock_button:hover
    {
      background-color:green ;

  }

  #lock_button:hover
    {
      background-color:red ;
    }



  .lock-unlock-btn
  {
    min-width:80px;
  }

</style>
@section('content')
<div class="container">
   <div class="col-md-12">
     <div class="col-md-11 col-md-offset-5">
        <div id="engine_off_processing"><i class="fa-li fa fa-spinner fa-spin fa-2x"></i></div>
       <h2 id="engine_status_alert"></h2>
        <i class="fa fa-car fa-5x" id="car-color" aria-hidden="true" style="color:red"></i><br><br>
     </div>


     <div class="col-md-4 col-md-offset-4">

       <div class="col-lg-12" id="btn_lock_unlock">
         <button value="" class="btn btn-default pull-left lock-unlock-btn"  data-value="0" id="unlock_button">Unlock</button>
         <button value="" class="btn btn-default pull-left lock-unlock-btn" data-value="1" id="lock_button">Lock</button>
     </div>

   </div>
</div>
</div>

@include('service.modal.password_confirmation_modal')
<hr class="style5">
<!--fuel-->
<div class="container">
    <div class="row">
  <div class="col-md-12">
        <div class="col-md-10 col-md-offset-1">
                <div class="panel-body">
                    <div class="row" style="margin-bottom: 20px; padding-left: 10px;">
                        <div class="form-inline">
                            <div class="form-group">

                                <input type="text" required="required" name="from_date" id="from_date_fuel" data-toggle="datepicker" class="form-control date" placeholder="from">

                            </div>
                            <div class="form-group">

                                <input type="text" required="required" name="to_date" id="to_date_fuel"  data-toggle="datepicker" class="form-control date" placeholder="to">

                            </div>
                            <div class="form-group">

                                <button class="btn btn-primary" id="load_fuel_history" type="button">
                                   <i class="fa fa-eye"></i>View
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <div class="col-md-2">
          <div id="fuel-percentage"
          data-dimension="200"
          data-info=""
          data-width="30"
          data-fontsize="38"
          data-percent="0"
          data-fgcolor=""
          data-bgcolor=""
          data-foregroundBorderWidth="40"
          data-backgroundBorderWidth= "40",
          data-foregroundColor= "#0000FF",
          data-backgroundColor="#00FF7F",
          data-fill="">
          </div>
          <div col-md-offset-3></div><h4>Fuel Percentage</h4>
      </div>

      <div class="col-md-10">
					<div class="col-md-8 col-md-offset-5">
						<div id="fuel-history-range-msg"  style="color:blue">

						</div>
					</div>
          <div class="col-md-12">
          <div id="fuel_histories">
					</div>
       </div>
      </div>
</div>
  </div>

</div>
<!--end fuel-->
<hr class="style5">

<!--gas-->
  <div class="container">
  <div class="row">
      <div class="col-md-12">
        <div class="col-md-10 col-md-offset-1">
                <div class="panel-body">
                    <div class="row" style="margin-bottom: 20px; padding-left: 10px;">
                        <div class="form-inline">
                            <div class="form-group">
                              <input type="text" required="required" name="from_date" id="from_date_gas" data-toggle="datepicker" class="form-control date" placeholder="from">
                            </div>
                            <div class="form-group">
                              <input type="text" required="required" name="to_date" id="to_date_gas"  data-toggle="datepicker" class="form-control date" placeholder="to">
                            </div>
                            <div class="form-group">
                                  <button class="btn btn-success" id="load_gas_history"  type="button">
                                  <i class="fa fa-eye"></i>View
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

          <div class="col-md-2 col-md-offset-0">
						<div id="gas_level_latest" style=""><br><br>
            <div id="gas_level5"></div><br>
              <div id="gas_level4"></div><br>
              <div id="gas_level3"></div><br>
              <div id="gas_level2"></div><br>
              <div id="gas_level1"></div>
            </div>
							<br>
                <h4>Gas Level</h4>
          </div>
          <div class="col-md-10">
              <div class="col-md-12">
              <!-- <div id="gas_histories"></div> -->
              <canvas id="bar_chart_gas" width="700" height="400"></canvas>
           </div>

          </div>
          <div class="col-md-7 col-md-offset-5"></div>
          </div>
        </div>

        </div>
<!--end gas-->
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/circliful/1.2.0/js/jquery.circliful.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script src="{{ asset('js/notify.min.js') }}" charset="utf-8"></script>
<script>
var bar_chart_gas =null;
 function getLabels(response) {
   return response.map(function(item) {
     return item.label;
   });
 }

 function getChartRow(i, response) {
   return response.map(function(item) {
     return i <= item.value ? 1 : 0;
   });
 }

 function getBgColor(i) {
   return i == 0 ? 'yellow  ' : 'green';
 }

 function getData(response) {
   var result = [];
   for(var i = 0; i<5; i++) {
     result.push({
    //   label: 'abcd',
       backgroundColor: getBgColor(i),
       data: getChartRow(i, response),
     });
		 result.push({
       backgroundColor: 'white',
       data: response.map(function(item) {return .1;}),
     });
   }
   return result;
 }

 function renderChart(response,title_text) {

   var barChartData = {
            labels: getLabels(response),
            datasets: getData(response),
        };

        if(bar_chart_gas!=null){
                bar_chart_gas.destroy();
            }

    var ctx = document.getElementById('bar_chart_gas').getContext('2d');

     bar_chart_gas = new Chart(ctx, {
      type: 'bar',
      data: barChartData,
      options: {
				maintainAspectRatio: false,
          title:{
              display:true,
              text:title_text
          },

          responsive: false,

          scales: {
              xAxes: [{
                  stacked: true,
                   gridLines: { display: false },
									 barThickness:30,
              }],
              yAxes: [{
                  stacked: true,
                   gridLines: { display: false },

									 ///drawBorder: false,
										 ticks : {
											 max : 6,
											 min : 0
									 },
								// 	scaleLabel: {
				        //     labelString: false
				        // },

              }]
          },
      }
    });

 }

 </script>

  <script>
    $(document).ready(function() {
        $("#engine_off_processing").hide()
        var attempt_value_lock_unlock = "";
        var user_id = '<?php echo Auth::user()->id;?>';
        var fuel_chart_color = "blue";
        var gas_chart_color = "green";
        var lock_status = null;
        var engine_status = null;
        var engine_status_sent_by_pusher;
        var car_id = '<?php echo $car;?>';
        var CAR_OFF=false;
        var EXIT=false;

        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawInitialCharts);

        //$("[name='toggle_car']").data('is_get', '0');
        $.get("/api/getState/" + user_id, function(data, status) {
            //state true means locked
            //state false means unlocked

            $("[name='toggle_car']").data('is_get', '1');
            lock_status = parseInt(data.lock_status);
            engine_status = parseInt(data.engine_status);
            if (engine_status == 1) {
                $("#engine_status_alert").html("");
                $("#engine_status_alert").html("Car ON ");
                $("#engine_status_alert").css("color",'green');
                $("#car-color").css('color', 'green')

            } else if (engine_status == 0) {
                $("#engine_status_alert").html("");
                $("#engine_status_alert").html("Car OFF ");
                $("#engine_status_alert").css("color",'red');

                $("#car-color").css('color', 'red')
            }

            if (lock_status == 1) {
                //$("[name='toggle_car']").bootstrapSwitch('state', true);
                $("#lock_button").addClass('btn btn-danger pull-left lock-unlock-btn');
                $("#unlock_button").addClass('btn btn-default pull-left lock-unlock-btn');
                $('#lock_button').text("Locked");
            //    $("#lock_button").attr('disabled', 'disabled');

            } else if (lock_status == 0) {
                //$("[name='toggle_car']").bootstrapSwitch('state', false);
                $("#lock_button").addClass('btn btn-default pull-left lock-unlock-btn');
                $("#unlock_button").addClass('btn btn-default pull-left lock-unlock-btn');
                $("#unlock_button").css('backgroundColor','green');
                $('#unlock_button').text("Unlocked");
            //    $("#unlock_button").attr('disabled', 'disabled');


            }
        });

        function setFuelPercentage(percent) {
           // console.log(percent);
            $("#fuel-percentage").attr("data-percent", percent.toString());
            $('#fuel-percentage').circliful();

        }

        function drawInitialCharts() {

            var today = moment(new Date()).format("YYYY-MM-DD");
            var two_weeks_ago= moment(new Date()).subtract(14, 'days').format("YYYY-MM-DD");
            console.log(two_weeks_ago);

            //setting up fuel percentage & gas  level

            $.post("/api/getFuelGasLevel", {
                'user_id': user_id
            }, function(result) {
                var gas_status = parseInt(result.data.gas);
                console.log(gas_status);
                if(gas_status==null)
                  gas_status=0;
                var fuel_status = result.data.fuel
                console.log(fuel_status)
                if(fuel_status==null)
                  fuel_status=0;
                setFuelPercentage(fuel_status) //setting up fuel percentage
                setGasLevel(gas_status); //gas level

            });

            $.post("/api/fuelHistories", {
                'from': two_weeks_ago,
                'to': today,
                'user_id': user_id
            }, function(result) {
                var result_arr = [];
                $.each(result.data, function(i, v) {
                   i = moment(i).format('MMM-DD')
                    result_arr.push([i, v]);
                });
                console.log(result_arr);
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', 'Fuel');
                data.addRows(result_arr);
                var options = {
                    hAxis: {
                        title: 'Date'
                    },
                    vAxis: {
                        title: 'Fuel'
                    },
                    backgroundColor: '#f1f8e9',
                    colors: [fuel_chart_color]
                };
                var chart = new google.visualization.LineChart(document.getElementById('fuel_histories'));
                $("#fuel-history-range-msg").html("Fuel Histories of Last 14 days")
                chart.draw(data, options);



            }, 'json');


              $.post("/api/gasHistories", {
                  'from': two_weeks_ago ,
                  'to': today,
                  'user_id': '<?php echo Auth::user()->id;?>'
              }, function(result) {
                       var response = [];
                       $.each(result.data, function(i, v) {
                         response.push({
                           label: moment(i).format('MMM-DD'),
                           value: v,
                         });

                      });
                      renderChart(response,"Gas Histories of Last 14 days");
                },'json');


                //console.log(gas_dates);


                // var data = new google.visualization.DataTable();
                // data.addColumn('string', 'Date');
                // data.addColumn('number', 'Gas');
                // data.addRows(result_arr);
                // var options = {
                //     hAxis: {
                //         title: 'Date'
                //     },
                //     vAxis: {
                //         title: 'Gas'
                //     },
                //     backgroundColor: '#f1f8e9',
                //     colors: [gas_chart_color]
                // };
                // var chart = new google.visualization.ColumnChart(document.getElementById('gas_histories'));
                //
                // chart.draw(data, options);



        //    }, 'json');

          //  console.log(result_arr);

        }

        $("#from_date_fuel").datepicker({
            format: 'yyyy-mm-dd',

        }).on('change', function(e) {
            $("#to_date_fuel").val("")
            const from_date_fuel = $(this).datepicker('getDate');

            $("#to_date_fuel").datepicker('destroy');

            $("#to_date_fuel").datepicker({
              format: 'yyyy-mm-dd',
              startDate:moment(from_date_fuel).toDate()
            })
           .on('change', function (e) {

              $(this).datepicker('hide');
             });

            $(this).datepicker('hide');
        });


        $("#from_date_gas").datepicker({
            format: 'yyyy-mm-dd',

        }).on('change', function(e) {
            $("#to_date_gas").val("")
            const from_date_gas= $(this).datepicker('getDate');
            $("#to_date_gas").datepicker('destroy');

            $("#to_date_gas").datepicker({
              format: 'yyyy-mm-dd',
              startDate:moment(from_date_gas).toDate()
            })
           .on('change', function (e) {

              $(this).datepicker('hide');
             });

            $(this).datepicker('hide');
        });




///date


        $("#load_fuel_history").click(function() {

            if ($("#from_date_fuel").val() == '' || $("#to_date_fuel").val() == '') {
                return $.confirm({
                    title: '<h2 style="color:red">Please Provide From & To Date</h2>',
                    content: '',
                    type: '',
                    typeAnimated: true,
                    buttons: {

                        close: function () {
                        }
                    }
                });
            }

            var from = $("#from_date_fuel").val();
            var to = $("#to_date_fuel").val();

            $.post("/api/fuelHistories", {
                'from': from,
                'to': to,
                'user_id': user_id
            }, function(result) {
                var result_arr = [];
                $.each(result.data, function(i, v) {
                  i = moment(i).format('MMM-DD')
                    result_arr.push([i, v]);
                });
                console.log(result_arr);
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', 'Fuel');
                data.addRows(result_arr);
                var options = {
                    hAxis: {
                        title: 'Date'
                    },
                    vAxis: {
                        title: 'Fuel'
                    },
                    backgroundColor: '#f1f8e9',
                    colors: [fuel_chart_color]
                };
                var chart = new google.visualization.LineChart(document.getElementById('fuel_histories'));

                $("#fuel-history-range-msg").html("Fuel Histories of Selected date range");

                chart.draw(data, options);


            }, 'json');

        });

        $("#load_gas_history").click(function() {

            if ($("#from_date_gas").val() == '' || $("#to_date_gas").val() == '') {
              return $.confirm({
                  title: '<h2 style="color:red">Please Provide From & To Date</h2>',
                  content: '',
                  type: '',
                  typeAnimated: false,
                  buttons: {

                      close: function () {
                      }
                  }
              });
            }

            var from = $("#from_date_gas").val();
            var to = $("#to_date_gas").val();

            $.post("/api/gasHistories", {
                'from': from ,
                'to': to,
                'user_id':user_id
            }, function(result) {
                     var response = [];
                     $.each(result.data, function(i, v) {
                       response.push({
                         label: moment(i).format('MMM-DD'),
                         value: v,
                       });

                    });
                      renderChart(response,"Gas Histories of Selected date range");
              },'json');

        });


       $('.btn-password-authorization').on('click',function(){

           if($("#password-authorize").val()=="")
            {
              $("#msg-password-authorize").html("Please Enter Password").css('color','red');
            }
            else{
              if(attempt_value_lock_unlock==1 && engine_status==1) //car is on  and attempt is lock
                {

                   LockUnlock($("#password-authorize").val(),1);

              }
              else{
                LockUnlock($("#password-authorize").val());
              }

          }
       });

      $('.lock-unlock-btn').on('click',function(e){
          attempt_value_lock_unlock = $(this).attr('data-value');
           if(attempt_value_lock_unlock==lock_status)
           return;
           console.log(attempt_value_lock_unlock);
           if(attempt_value_lock_unlock==1 && engine_status==1) //car is on  and attempt is lock
             {
               return $.confirm({
                   title: 'Lock Attempted.This process will take some time',
                   content: '<h5 style="color:red">Are you sure? Car will be turned OFF</h5>',
                   buttons: {
                       confirm: function () {
                            $("#password-confirmation-modal").modal('show');
                          //  $("#engine_off_processing")
                       },
                       cancel: function () {
                           //$.alert('Canceled!');
                       },

                   },

               });
             }
            else
            {
              $("#password-confirmation-modal").modal('show');
            }

      });

      function ClearFormInsideModal()
      {
        $("#password-authorize").val("");
        $("#msg-password-authorize").html("");
      }

      function checkEngineStatusPeriodically()
      {

       $.ajax({
              type: "POST",
              url: "/api/getLocknEngineState",
              data: {'car_id':car_id},
              success: function(response) {
                    if(response.data.engine_status==0)
                    {
                       engine_status=0;
                       CAR_OFF=true;
                       $("#engine_off_processing").hide();
                       EXIT=true;
                       //console.log(EXIT);
                       //$.notify("Car has turned OFF","info");
                        return ;
                    }
              }
          });

      }

      function LockUnlock_second_attempt(PASSWORD)
      {

        $.post("/api/toggleEngineWEB", {
                  'user_id': user_id,
                  'lock_status': attempt_value_lock_unlock,
                  'password':PASSWORD
              },
              function(response) {
                    var msg = response.message;
                    console.log(response.data);
                    var Interval = setInterval(checkEngineStatusPeriodically ,7000);
                    var Timeout =  setTimeout(function(){clearInterval(Interval)

                       if(CAR_OFF==false)
                         {
                             $("#engine_off_processing").hide();
                             $.notify("Car Could not off,please wait or try again..", {
                               className:'info',
                               //clickToHide: false,
                               autoHide: true,
                               globalPosition: 'top right'
                             });
                         }


                       },21000);

                  if (response.data.engine_status == 1) {
                      engine_status=1;
                       $("#engine_off_processing").hide();
                      $("#engine_status_alert").html("");
                      $("#engine_status_alert").html("Car ON ");
                      $("#engine_status_alert").css("color",'green');
                      $("#car-color").css('color', 'green')

                  } else if (response.data.engine_status == 0) {
                      engine_status=0;
                       $("#engine_off_processing").hide();
                      $("#engine_status_alert").html("");
                      $("#engine_status_alert").html("Car OFF ");
                      $("#engine_status_alert").css("color",'red');
                      $("#car-color").css('color', 'red')
                  }
              });

      }
      function LockUnlock(PASSWORD,type)
      {
        $.post("/api/toggleEngineWEB", {
                'user_id': user_id,
                'lock_status': attempt_value_lock_unlock,
                'password':PASSWORD
            },
            function(response) {
                var msg = response.message;
                console.log(response.data);
                if (response.status == 0) {
                  $("#msg-password-authorize").html(response.message).css('color','red');
                  return
                }
                else{
                if (response.data.lock_status == 1) {
                  $("#lock_button").addClass('btn btn-danger pull-left lock-unlock-btn');
                  $("#unlock_button").addClass('btn btn-default pull-left lock-unlock-btn');
                  $("#unlock_button").css('backgroundColor','');
                  $("#lock_button").text("Locked");
                  $("#unlock_button").text("UnLock");
                  lock_status=1;
                  if(type==1)
                   {
                     $("#engine_off_processing").show();

                     var Interval = setInterval(checkEngineStatusPeriodically ,7000);

                     var Timeout =   setTimeout(function(){

                       clearInterval(Interval)
                       //console.log(EXIT+'EXIT')
                      //console.log(CAR_OFF+"FIRST_CALL")
                      if(CAR_OFF==false)
                        {
                         setTimeout(function(){console.log('1111')}, 1000);

                        LockUnlock_second_attempt(PASSWORD);
                        }
                      },21000);

                   }

                } else if (response.data.lock_status == 0) {
                  console.log("unlocked");
                  $("#lock_button").removeClass('btn-danger');
                  $("#lock_button").addClass('btn btn-default pull-left lock-unlock-btn');
                  $("#unlock_button").css('backgroundColor','green');
                  $("#lock_button").text("Lock");
                  $("#unlock_button").text("UnLocked");
                  lock_status=0;
                }

                if (response.data.engine_status == 1) {
                   engine_status=1;
                    $("#engine_status_alert").html("");
                    $("#engine_status_alert").html("Car ON ");
                    $("#engine_status_alert").css("color",'green');
                    $("#car-color").css('color', 'green')

                } else if (response.data.engine_status == 0) {
                    engine_status=0;
                    $("#engine_status_alert").html("");
                    $("#engine_status_alert").html("Car OFF ");
                    $("#engine_status_alert").css("color",'red');
                    $("#car-color").css('color', 'red')
                }

                 ClearFormInsideModal();
                $("#password-confirmation-modal").modal('hide');

            }

            });
      }


      $('.modal-close').on('click',function (e) {
           console.log(this);
           ClearFormInsideModal();
       });
        $('#password-authorize').on('keyup',function (e) {
          // console.log(this)
          $("#msg-password-authorize").html("");
      });
  });

</script>
<script src="https://js.pusher.com/4.0/pusher.min.js"></script>
<script>
//
function setGasLevel(gas_level) {
        switch (gas_level) {
            case 0:
                  $("#gas_level2").css('background', 'white')
                  $("#gas_level3").css('background', 'white')
                  $("#gas_level4").css('background', 'white')
                  $("#gas_level5").css('background', 'white')
                 break;
            case 1:
                $("#gas_level3").css('background', 'white')
                $("#gas_level4").css('background', 'white')
                $("#gas_level5").css('background', 'white')
                break;
            case 2:
                $("#gas_level4").css('background', 'white')
                $("#gas_level5").css('background', 'white')
                break;
            case 3:
                $("#gas_level5").css('background', 'white')
                break;
            case 4:
                return
             case null:
                 $("#gas_level2").css('background', 'white')
                 $("#gas_level3").css('background', 'white')
                 $("#gas_level4").css('background', 'white')
                 $("#gas_level5").css('background', 'white')
                break;
        }
    }
  var user_id = '<?php echo Auth::user()->id;?>';
    var pusher = new Pusher('e104f912331445995538', {
        cluster: 'ap1',
        encrypted: false
    });
    var state = pusher.connection.state;

    var channel = pusher.subscribe('map-channel-' + user_id);

    function unsubscribe_channel(channelName) {
        pusher.unsubscribe(channelName);
    }

    function subscribe_channel(channelName) {
        pusher.subscribe(channelName);
    }

    channel.bind('engine-event', function(data) {
        if (data.message.engine_status == 0) {
           engine_status=0;
            $.notify("Car has turned OFF","info");
           engine_status_sent_by_pusher=false;
            console.log(data.message.engine_status)
           $("#engine_off_processing").hide();
            $("#engine_status_alert").html("");
            $("#engine_status_alert").html("Car OFF");
            $("#engine_status_alert").css("color",'red');
            $("#car-color").css('color', 'red')
            //alert("Car ON");
        } else if (data.message.engine_status == 1) {
            console.log(data.message.engine_status)
            engine_status_sent_by_pusher = true;
            engine_status=1;
            $("#engine_status_alert").html("");
            $("#engine_status_alert").html("Car ON");
            $("#car-color").css('color', 'green')
            $("#engine_status_alert").css("color",'green');
            //alert("Car ON");
        }

    });

      channel.bind('fuel-event', function(data) {
           var fuel_status =data.message.fuel_status;
           console.log(fuel_status)

      });

      channel.bind('gas-event', function(data) {
           var gas_status =data.message.gas_status;
           console.log(gas_status);

      });



</script>

@endsection
