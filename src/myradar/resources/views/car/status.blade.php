@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Car Status
                </div>
                <div class="panel-body">
                    <h4>
                        {{$car->name}} ( {{$car->reg_no}} )
                        <a href="/car/details/{{$car->id}}"><i class="fa fa-info-circle"></i></a>
                        <br>
                    </h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $key => $service)
                                <tr>
                                    <td>{{$service->name}}</td>
                                    <td><strong class="status_label" data-status="{{$car->device->getServiceStatus($service)}}"></strong></td>
                                </tr>
                            @endforeach
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
<script type="text/javascript">
    $(function() {
        $('.status_label').each(function(i, el) {
            console.log("status: " + i);
            var $this = $(el);
            var status = parseInt($this.data('status'));
            var label = '';
            var style = '';
            if (status == 1) {
                label = 'GOOD';
                style = 'text-success';
            } else if (status == 2) {
                label = 'AVARAGE';
                style = 'text-muted';
            } else {
                label = 'DISCONNECTED';
                style = 'text-danger';
            }

            $this.text(label);
            $this.addClass(style);
        });
    });
</script>
@endsection
