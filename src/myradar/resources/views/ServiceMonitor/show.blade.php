@extends('layouts.new')

@push('style')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/datetimepicker.min.css') }}">
<style>
  td.highlight {
      background-color: whitesmoke !important;
}
div.dt-buttons{
position:relative;
float:left;
}

</style>
@endpush

@section('content')
  <div class="col-md-10 col-md-offset-1">
          <div class="panel-body">
              <div class="row" style="margin-bottom: 20px; padding-left: 10px;">
                  <div class="form-inline">
                    <form class="form" action="/service-monitor" method="get">

                        <div class="form-group">
                              {!!  Form::select('user_id', $users, '',['class' => 'form-control','id'=>'user_id']) !!}

                        </div>

                        <div class="form-group">
                            <select class="form-control" name="service_id">
                                <option value="777">Device Health</option>
                                <option value="0">Lat/Lng</option>
                                <option value="16">Fuel</option>
                                <option value="17">Gas</option>
                            </select>
                        </div>

                      <div class="form-group">
                        <input type="text" required="required"  name="from_date" id="from_date" data-toggle="datepicker" class="form-control date" placeholder="from">
                      </div>
                      <div class="form-group">
                        <input type="text" required="required"  name="to_date" id="to_date"  data-toggle="datepicker" class="form-control date" placeholder="to">
                      </div>
                      <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            {!! Form::submit('Search', ['class' => 'btn btn-sm btn-success pull-right'] ) !!}
                        </div>

                      </div>
                     <div class="form-group"></br></br>
                      <!-- <button class="btn btn-sm btn-primary pull-right" value="2" type="submit" name="export">Export Shown <i class="fa fa-file-excel-o"></i></button> -->

                      <button class="btn btn-sm btn-primary pull-right" value="1" type="submit" name="export">Export <i class="fa fa-file-excel-o"></i></button>
                       </div>
                      </form>
                      </div>
                  </div>
              </div>


              @if(isset($histories))

              {{ $histories->appends(request()->input())->links()}}

              @endif
              <div class="container">
                  <!-- <a href="/service-monitor"><i class="fa fa-refresh fa-2x" aria-hidden="true"></i></a> -->
                  <table  id="myTable" class="table table-striped table-bordered table-hover table-responsive" cellspacing="0"
                      width="100%" role="grid" style="width: 100%;">
               <thead>
                  <th class="no-sort">Date Time </th>
                  @if($sid==0)
                  <th>Lat</th>
                   <th>Long</th>
                   @elseif($sid==777)
                   <th>Loop Count</th>
                   <th>SetUp Time (Second)</th>
                   <th>Avg Loop Time(Second)</th>
                   <th>Min Loop Time(Second)</th>
                   <th>Max Loop Time(Second)</th>
                   <th>Min Free Ram</th>
                   <th>Max Free Ram</th>
                   @else
                   <th>Value</th>
                  @endif

               </thead>

                <tbody>
                @if(!empty($histories))
                    @foreach ($histories as $histories)
                    <tr>

                  <!-- <td>  {{ Carbon\Carbon::parse($histories->when)->format('g:i A, d M Y') }}</td>
                   -->
                     @if(isset($histories->when))
                   <td>  {{ Carbon\Carbon::parse($histories->when)->format('d M Y g:i:s A') }}</td>
                      @else
                      <td>  {{ Carbon\Carbon::parse($histories->created_at)->format('d M Y g:i:s A') }}</td>

                    @endif
                  <!-- <td>{{$histories->when}}</td> -->
                    @if($sid==0)
                      <td>{{ $histories->lat }}</td>
                      <td>{{ $histories->lng}}</td>
                      @elseif($sid==777)
                      <td>{{ $histories->loop_count}}</td>
                      <td>{{ $histories->setup_time/1000 }}</td>
                      <td>{{ $histories->avg_loop_time/1000 }}</td>
                      <td>{{ $histories->min_loop_time/1000 }}</td>
                      <td>{{ $histories->max_loop_time/1000 }}</td>
                      <td>{{ $histories->min_free_ram }}</td>
                      <td>{{ $histories->max_free_ram }}</td>
                      @else
                      <td>{{ $histories->value }}</td>
                     @endif

                    </tr>
                    @endforeach


                   @endif

              </tbody>
                </table>
              </div>
          </div>



@endsection



@push('script')


<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js"></script>


<script src="{{ asset('js/moment.min.js') }}" charset="utf-8"></script>
<script src="{{ asset('js/datetimepicker.min.js') }}" charset="utf-8"></script>
<script>

$(document).ready(function() {
 //$('#myTable').DataTable();
 //
 // var get_export_type =
 //
 // var export_type = "Data Export";
 // var username="";
 //  username =$('#user_id :selected').text();
 //
 // $("#user_id").on('change',function(){
 //    username = $(this).text();
 // });
 // console.log(get_export_type);
 // console.log(username);
 // if(get_export_type=='0')
 // {
 //   export_type = "Lat Long"
 // }
 // else if (get_export_type=='16') {
 //   export_type = "Fuel"
 // }
 //
 // else if (get_export_type=='17') {
 //
 //   export_type = "Gas"
 // }

 //$.fn.dataTable.moment('dd/MM/yy hh:mm:ss A');


  // $('#myTable').DataTable( {
  //      dom: 'Blfrtip',
  //       //ordering: false,
  //     lengthMenu: [[5, 10, 15,20,50,100,150,200,250,300,400,500,-1], [5, 10, 15,20,50,100,150,200,250,300,400,500,"All"]],
  //       buttons: [
  //        { "extend": 'excel', "text":'Export <i class="fa fa-file-excel-o" aria-hidden="true"></i><br>',"className": 'btn btn-info btn-md',
  //
  //          "title": export_type,
  //           filename: function(){
  //               var date = moment().format('MM-DD-YYYY');
  //
  //               return export_type +'_'+ username +'_'+ date ;
  //           },
  //
  //        }
  //    ],
  //
  //    columnDefs: [ {
  //       "targets": 0,
  //       "searchable": true,
  //       //"type":'date'
  //     } ]
  //
  //   } );

var from_date = '<?php if(isset($from_date)) {echo $from_date; }?>';
console.log(from_date);

var to_date = '<?php if(isset($to_date)) {echo $to_date; }?>';
 console.log(to_date);

if(from_date !='' && to_date !='')
{
  //$("#from_date").val(from);
  $('#from_date').val(moment(from_date).format('MM/DD/YYYY hh:mm A'));
  $('#to_date').val(moment(to_date).format('MM/DD/YYYY hh:mm A'));

}


$('.date').datetimepicker({
  showClear: true,
  //defaultDate:new Date()
  format : "MM/DD/YYYY hh:mm A"

}).on('change', function(e) {
    $(this).datetimepicker('hide');
});


})
</script>
@endpush
