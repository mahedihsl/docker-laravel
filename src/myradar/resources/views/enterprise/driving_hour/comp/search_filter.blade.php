<form class="driving-hour-form" action="/enterprise/driving-hour/result" method="get">
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="car_reg_no" id="car_reg_no" class="form-control" placeholder="Car Reg No." value="{{$car_reg_no or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="owner_name" id="owner_name" class="form-control" placeholder="Owner Name" value="{{$owner_name or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="owner_phone" id="owner_phone" class="form-control" placeholder="Phone" value="{{$owner_phone or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="driver_name" id ="driver_name" class="form-control" placeholder="Driver name" value="{{$driver_name or ''}}">
                <p class="help-block"></p>
            </div>
        </div>

        <div class="col-sm-2">
            <input type="submit" class="btn btn-sm btn-primary" name="search" id="driving-hour-search" value="Search" />
            <a class="btn btn-sm btn-default" href="/enterprise/driving-hour/report"><i class="fa fa-refresh fa-1x"></i></a>
        </div>
    </div>
</form>
