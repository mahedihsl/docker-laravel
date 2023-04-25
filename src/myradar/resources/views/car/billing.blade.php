@extends('layouts.new')

@push('style')
  <style media="screen">
  .user-thumb {
      width: 45px;
      height: 45px;
      radius: 50%;
      margin: 10px auto;
  }
  .table > tbody > tr > td {
      vertical-align: middle;
  }
  .user-name {
      display: inline-block;
      margin-top: 12px;
  }
  .user-phone {
      display: block;
  }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('car.comp.filter_form', ['data' => $params])
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th class="text-center col-xs-1">#</th>
            <th class="col-xs-3">Customer</th>
            <th class="text-center col-xs-2">Reg. No.</th>
            <th class="text-center col-xs-2">Payment / <br> Validity</th>
            <th class="text-center col-xs-2">Sys. Status </th>
          </tr>
        </thead>
        <tbody>
          @php
            $from = ($cars->currentPage() - 1) * $cars->count() + 1;
          @endphp
          @foreach ($cars as $key => $car)
            @if ( ! is_null($car->user))
              @include('car.comp.table_item', [
                'car' => $car,
                'serial' => $from + $key
              ])
            @endif
          @endforeach
        </tbody>
      </table>
      {!! $cars->links() !!}
    </div>
  </div>

  <div class="import-form">
    <form action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
      <input type="file" name="import_file" />
        {{ csrf_field() }}<br/>
        <button class="btn btn-primary">Import Billing Info</button>
      </form>
    </div>
    <a class="btn btn-sm btn-default"href={{ asset('Files/import_file.xlsx') }}><i class="fa fa-download 2x"></i> Download Excel Template</a>
@endsection

@push('script')
<script type="text/javascript">
  $(function() {
    $('[data-toggle="datepicker"]').datepicker();

    $(".dev_check").change(function(){
      console.log(this);
    });

    $("#search_by").change(function(){
      $("#search_for").val('');
      if($(this).val()=='validity'){
        $("#search_for").prop("type", "date");
      } else {
        $("#search_for").prop("type", "text");
      }
    });
  });
</script>
@endpush
