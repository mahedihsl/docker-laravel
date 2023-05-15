@extends('layouts.app')


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>

<script src="{{ asset('js/moment.min.js') }}" charset="utf-8"></script>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Service Diagnosis <a href="/service/serviceLog"><i class="fa fa-arrow-circle-left fa-2x"></i></a>  </div><br>

                <form>
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-1">
                            <div class="form-group">
                               <input type="hidden" name="user_id" id ="user_id" value="{{Request::segment(3)}}">
                              <input type="text" required="required" name="from_date" id="from_date" data-toggle="datepicker" class="form-control date" placeholder="from">
                                  <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                              <input type="text" required="required" name="to_date" id="to_date"  data-toggle="datepicker" class="form-control date" placeholder="to">

                              <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="col-sm-2">
                          <button class="btn btn-success" id="load_data" type="button">
                              View<i class="fa fa-eye"></i>
                            </div>

                        </div>
                    </div>
                </form>


                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
              <div id="timeline" style="height: 180px; width: 100%; overflow-x: scroll;
                overflow-y: hidden;"></div>
              <input id="date_width_slider" type="range" />
              </div>
    </div>
</div>

@endsection
@section('js')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{ asset('js/moment.min.js') }}" charset="utf-8"></script>

<script>

   $(function(){

    //  shwoing log for last 15 days


    //  $('.date').datepicker({
    //        format: 'yyyy-mm-dd'
    //       }).on('change', function(e){
    //           $(this).datepicker('hide');
    //       });

      $("#from_date").datepicker({
          format: 'yyyy-mm-dd',
      }).on('change', function(e) {
          $("#to_date").val("")
          const from_date= $(this).datepicker('getDate');
          $("#to_date").datepicker('destroy');
          $("#to_date").datepicker({
            format: 'yyyy-mm-dd',
            startDate:moment(from_date).toDate()
          })
          .on('change', function (e) {
            //console.log("amran");
            $(this).datepicker('hide');

           });

          $(this).datepicker('hide');
      });

          $("#to_date").datepicker({
            format: 'yyyy-mm-dd',

            })
             .on('change', function (e) {
              //console.log("amran");
              $(this).datepicker('hide');

             });

      $("#to_date").val(moment().format('YYYY-MM-DD'));
      $("#from_date").val(moment().subtract(15, "days").format("YYYY-MM-DD"));
      reloadBtnPressed();


   });

</script>
<script>
    google.charts.load('current', {
        'packages': ['timeline']
    });
    google.charts.setOnLoadCallback(onGoogleChartLoadCallBackFired);

    var loadBtn = document.getElementById("load_data");
    loadBtn.addEventListener('click', reloadBtnPressed);
    loadBtn.disabled = true;

    var dayWidthSlider = document.getElementById("date_width_slider");
    dayWidthSlider.addEventListener('change', dayWidthSliderChanged);
    dayWidthSlider.disabled = true;


    function onGoogleChartLoadCallBackFired() {
        loadBtn.disabled = false;
        dayWidthSlider.disabled = false;
    }

    function dayWidthSliderChanged() {
        reloadBtnPressed();
    }

    function reloadBtnPressed() {
        //
        //	fetch your data from ap call's
        //	and then feed the data to the drawChart
        //

        var jsonString = "{}";

        if ($("#from_date").val() == '' || $("#to_date").val() == '') {
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

        var from = $("#from_date").val();
        var to = $("#to_date").val();
        var user_id =$("#user_id").val();
        console.log(jsonString);

        $.post("/service/api/get_service_diagnosis", {
            'from': from,
            'to': to,
            'user_id':user_id,
            // 'phone':phone,
            // 'reg':reg
        }, function(result) {
            console.log(result.result);
            jsonString = result.result;
             service_name = result.service_name;
            // console.log(jsonString);

            var dayWidthSlider = document.getElementById("date_width_slider");
            var perDayWidth = dayWidthSlider.value;

            var maxDate = calculateMaxDate(jsonString);
            var minDate = calculateMinDate(jsonString);

            var numOfDays = numberOfDayBetweenTwoDate(minDate, maxDate);

            console.log(minDate);

            maxDate.setMonth(maxDate.getMonth() - 1);

            console.log(maxDate);

            drawChart(convertToGoogleChartFormat(jsonString), maxDate, (numOfDays + 1) * Math.max(70, perDayWidth * 1.2));

        }, 'json');

        // console.log(jsonString);



    }

    function numberOfDayBetweenTwoDate(date1, date2) {
        var oneDay = 24 * 60 * 60 * 1000;
        return Math.round(Math.abs((date1.getTime() - date2.getTime()) / (oneDay)));
    }

    function calculateMaxDate(json) {
        console.log('date json: ' + json);
        var jsonData = JSON.parse(json);
        var maxDate = new Date("1970-01-01");
        for (var dateString in jsonData) {
            var dateFromString = new Date(dateString);
            if (dateFromString > maxDate)
                maxDate = dateFromString;
        }

        return maxDate;
    }

    function calculateMinDate(json) {
        var jsonData = JSON.parse(json);
        var minDate = new Date();
        for (var dateString in jsonData) {
            var dateFromString = new Date(dateString);
            if (dateFromString < minDate)
                minDate = dateFromString;
        }

        return minDate;
    }

    function getNextDateOfGivenDate(givenDate) {
        var returnDate = new Date(givenDate);
        returnDate.setDate(givenDate.getDate() + 1);
        return returnDate;
    }

    function convertToGoogleChartFormat(amranJson) {
        var jsonData = JSON.parse(amranJson);

        var processedData = [];

        for (var dateString in jsonData) {
            // process the dates
            var startDate = new Date(dateString);
            startDate.setHours(0);
            startDate.setSeconds(0);
            startDate.setMinutes(0);
            var nextDate = getNextDateOfGivenDate(startDate);
            for (var index = 0; index < jsonData[dateString].length; index++) {
                 var serviceName = jsonData[dateString][index];
              ///  var serviceName = service_name[s_index];

                processedData.push([serviceName,//service name
                    startDate,
                    nextDate,
                    "#1" // for tooltip
                ]);
            }
        }
        return processedData;
    }




    function drawChart(data, maxDate, timelineWidth) {
        var container = document.getElementById('timeline');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();

        dataTable.addColumn({
            type: 'string',
            id: 'Service'
        });

        dataTable.addColumn({
            type: 'date',
            id: 'Start'
        });

        dataTable.addColumn({
            type: 'date',
            id: 'End'
        });

        dataTable.addColumn({
            type: 'string',
            role: 'tooltip'
        });

        dataTable.addRows(data);

        chart.draw(dataTable, {
            hAxis: {
                maxValue: maxDate,
                format: 'MMM d '
            },

            width: timelineWidth,
            backgroundColor: null,
            colors: ['purple', 'green', 'yellow']
        });

    }


</script>


@endsection
