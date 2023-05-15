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
                      Tail Report
                      <input type="hidden" name="userid" value="{{$user->id}}">
                   </h3>
                </div>

                <div class="panel-body">
                   @include('enterprise.tail.comp.search_filter', ['data' => ''])

           <table  id="myTable" class="table table-striped table-bordered table-hover table-responsive">
                   <thead>
                      <th>Car Reg No.</th>
                       <th>Driver</th>
                       <th>Owner Name.</th>
                       <th>Owner Phone</th>
                       <th>'--'</th>
                       <th>Daywise</th>
                   </thead>
                    <tbody>
                      <div id="no_data_found"></div>
                    @if(!empty($data))
                        @foreach ($data as $data)
                        <tr>
                          <td>{{$data['car_no']}}</td>
                          <td>{{$data['driver_name']}}</td>
                          <td>{{$data['owner_name']}}</td>
                          <td>{{$data['owner_phone']}}</td>
                          <td>{{'-'}}</td>
                          <td>{{'button'}}</td>
                        </tr>
                        @endforeach
                       @endif

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
  $(document).ready(function(){
    $('#report_type').select2();
    $('#comparison_value').select2();
    $('#comparsion_value').change(function(){
      if($(this).val()=='4'||$(this).val()=='5')
        {
           $("#filter_value").hide();
        }
        else{
          $("#filter_value").show();
        }

    });

   });
  </script>

  <script>


  </script>
  @endsection
