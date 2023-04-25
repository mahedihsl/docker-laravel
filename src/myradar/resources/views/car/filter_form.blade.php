<form class="" action="/billing" method="get">
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Customer Name" value="{{$data['name'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="Customer Phone" value="{{$data['phone'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="reg" class="form-control" placeholder="Reg. no" value="{{$data['reg'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="remain" class="form-control" placeholder="Remaining MB" value="{{$data['remain'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" data-toggle="datepicker" name="valid" class="form-control" placeholder="Validity" value="{{$data['valid'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="submit" class="btn btn-sm btn-primary" name="type" value="search" />
            <input type="submit" class="btn btn-sm btn-info" name="type" value="export" />
        </div>
    </div>
</form>
