@extends('layouts.new')

@push('style')
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/datetimepicker.min.css', $hasHttps) }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <style>
    td.highlight {
      background-color: whitesmoke !important;
    }

    div.dt-buttons {
      position: relative;
      float: left;
    }
  </style>
@endpush

@section('content')
  <div class="col-md-12">
    <div class="panel-body">
      <div class="row" style="margin-bottom: 20px; padding-left: 10px;">
        <div class="form-inline">
          <form class="form" action="/service-monitor" method="get">
            <div class="form-group">
              <input type="hidden" name="user_name" value="" data-name="{{ $user_name }}">
              <input id="nameSuggests" type="hidden" placeholder="type user name" autocomplete="off"
                data-cache="{{ $users }}">
              <select class="js-example-data-array" name="user_id" data-cache="{{ $user_id }}">

              </select>
            </div>

            <div class="form-group" id="site_container">
              <select class="form-control" id="sites" name="site_id" value="">
              </select>
            </div>

            <div class="form-group">
              <select class="form-control" id="devices" name="device_id" value=""
                data-cache="{{ $device_id }}">
              </select>
            </div>

            <div class="form-group">
              <select class="form-control" name="service_id" data-cache="{{ $service_id }}">
                <option value="23">Service String</option>
                <option value="777">Device Health</option>
                <option value="0">Lat/Lng</option>
                <option value="16">Fuel</option>
                <option value="21">Fuel (Avg. 1st)</option>
                <option value="22">Fuel (Avg. 2nd)</option>
                <option value="17">Gas</option>
                <option value="20">IBS</option>
              </select>
            </div>

            <div class="form-group">
              <input type="text" required="required" name="from_date" id="from_date" data-toggle="datepicker"
                class="form-control date" placeholder="from">
            </div>
            <div class="form-group">
              <input type="text" required="required" name="to_date" id="to_date" data-toggle="datepicker"
                class="form-control date" placeholder="to">
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-sm btn-success pull-right" name="filter">Filter</button>
              </div>

            </div>
            <div class="form-group">
              <!-- <button class="btn btn-sm btn-primary pull-right" value="2" type="submit" name="export">Export Shown <i class="fa fa-file-excel-o"></i></button> -->

              <button class="btn btn-sm btn-primary pull-right" value="1" type="submit" name="export">Export <i
                  class="fa fa-file-excel-o"></i></button>
            </div>
          </form>
        </div>
      </div>
    </div>


    @if (isset($histories))
      {{ $histories->setPath('/service-monitor')->appends(request()->input())->links() }}
    @endif
    <div class="container">
      <!-- <a href="/service-monitor"><i class="fa fa-refresh fa-2x" aria-hidden="true"></i></a> -->
      <div class="row">
        <div class="col-md-12 table-responsive">
          <table id="myTable" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="no-sort">Date Time </th>
                @if ($sid == 0)
                  <th>Lat</th>
                  <th>Long</th>
                @elseif($sid == 777)
                  <th>Loop Count</th>
                  <th>ES</th>
                  <th>Setup Time (sec)</th>
                  <th>Avg Loop Time (sec)</th>
                  <th>Min Loop Time (sec)</th>
                  <th>Max Loop Time (sec)</th>
                  <th>Min Free Ram</th>
                  <th>Max Free Ram</th>
                  <th>Session Time</th>
                  <th>Shield Count</th>
                  <th>GPS Power</th>
                  <th>CR</th>
                  <th>WR</th>
                  <th>MCUCSR</th>
                  <th>Version</th>
                @else
                  <th>Value</th>
                @endif
              </tr>

            </thead>

            <tbody>
              @if (!empty($histories))
                @foreach ($histories as $histories)
                  <tr>

                    @if (isset($histories->when))
                      <td> {{ Carbon\Carbon::parse($histories->when)->format('d M Y g:i:s A') }}</td>
                    @else
                      <td> {{ Carbon\Carbon::parse($histories->created_at)->format('d M Y g:i:s A') }}</td>
                    @endif
                    <!-- <td>{{ $histories->when }}</td> -->
                    @if ($sid == 0)
                      <td>xx.xxxx</td>
                      <td>xx.xxxx</td>
                      {{-- <td>{{ $histories->lat }}</td>
              <td>{{ $histories->lng}}</td> --}}
                    @elseif($sid == 777)
                      <td>{{ $histories->loop_count }}</td>
                      <td>{{ $histories->es or '-1' }}</td>
                      <td>{{ $histories->setup_time / 1000 }}</td>
                      <td>{{ $histories->avg_loop_time / 1000 }}</td>
                      <td>{{ $histories->min_loop_time / 1000 }}</td>
                      <td>{{ $histories->max_loop_time / 1000 }}</td>
                      <td>{{ $histories->min_free_ram }}</td>
                      <td>{{ $histories->max_free_ram }}</td>
                      <td>{{ $histories->session_time or '-1' }}</td>
                      <td>{{ $histories->shield_count or '-1' }}</td>
                      <td>{{ $histories->gps_power or '-1' }}</td>
                      <td>{{ $histories->cr or '-1' }}</td>
                      <td>{{ $histories->wr or '-1' }}</td>
                      <td>{{ $histories->mcucsr() }}</td>
                      <td>{{ $histories->version or '--' }}</td>
                    @else
                      <td>
                        @if (isset($histories->value))
                          {{ $histories->value }}
                        @elseif(isset($histories->data))
                          {{ $histories->data }}
                        @else
                          N/A
                        @endif
                      </td>
                    @endif

                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
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
  <script src="{{ asset('js/moment.min.js', $hasHttps) }}" charset="utf-8"></script>
  <script src="{{ asset('js/datetimepicker.min.js', $hasHttps) }}" charset="utf-8"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script>
    var sites = [];

    function getDevices(userId) {
      $.get('/user/devices/' + userId, function(response) {
        var select = $('select[name="device_id"]');
        select.empty();
        var flag = false;
        var cache = select.data('cache');

        for (var i = 0; i < response.data.length; i++) {
          if (cache == response.data[i]._id) flag = true;
          select.append($('<option>', {
            val: response.data[i]._id,
            text: response.data[i].com_id,
          }));
        }
        console.log(flag);
        if (flag) select.val(cache);

        getRMSSites(userId);
      });
    }

    function getRMSSites(userId) {
      $.get('/api/rms/site/list', {user_id: userId}, function(response) {
        sites = response

        var select = $('select[name="site_id"');
        select.empty();

        var selectedSiteId = null;
        var selectedDeviceId = parseInt($('select[name="device_id"]').data('cache'));

        for (let i = 0; i < response.length; i++) {
          select.append($('<option>', {
            val: response[i].id,
            text: response[i].name,
          }))

          if (response[i].com_ids.includes(selectedDeviceId)) {
            selectedSiteId = response[i].id;
          }
        }

        if (selectedSiteId) {
          select.val(selectedSiteId)
          onSiteChanged(selectedSiteId)
        } else if(sites.length) {
          onSiteChanged(sites[0].id)
        }
      })
    }

    function onSiteChanged(siteId) {
      var site = sites.find(s => s.id === siteId)

      var deviceSelect = $('select[name="device_id"]');
      if (site) {
        deviceSelect.empty()
        var flag = false;
        var cache = deviceSelect.data('cache')
        for (let i = 0; i < site.com_ids.length; i++) {
          let comId = site.com_ids[i];
          if (cache == comId) flag = true;
          deviceSelect.append($('<option>', {
            val: comId,
            text: comId,
          }));
        }
        if(flag) deviceSelect.val(cache)
      }
    }

    $(document).ready(function() {
      let selected_user = $('select[name="user_id"]');
      let selected_site = $('select[name="site_id"]');
      let selected_user_name = $('input[name="user_name"]');

      selected_user.change(function() {
        getDevices($(this).val());
      });

      selected_site.change(function() {
        var siteId = $(this).val();
        onSiteChanged(siteId)
      })

      var service_select = $('select[name="service_id"]');
      var sid = '' + service_select.data('cache');
      if (sid.length) {
        service_select.val(sid);
      }

      var from_date = '<?php if (isset($from_date)) { echo $from_date; } ?>';
      var to_date = '<?php if (isset($to_date)) { echo $to_date; } ?>';

      if (from_date != '' && to_date != '') {
        $('#from_date').val(moment(from_date).format('MM/DD/YYYY hh:mm A'));
        $('#to_date').val(moment(to_date).format('MM/DD/YYYY hh:mm A'));

      }


      $('.date').datetimepicker({
        showClear: true,
        //defaultDate:new Date()
        format: "MM/DD/YYYY hh:mm A"

      }).on('change', function(e) {
        $(this).datetimepicker('hide');
      });


      var choices = $('#nameSuggests').data('cache');

      $(".js-example-data-array").select2({
        data: choices,
        width: '160px',
        placeholder: 'Select User',
      })

      if (selected_user.data('cache')) {
        selected_user.val(selected_user.data('cache'));
        selected_user.select2({
          id: selected_user.data('cache'),
          text: selected_user_name.data('name')
        });
        selected_user.change();
      }

    });
  </script>
@endpush
