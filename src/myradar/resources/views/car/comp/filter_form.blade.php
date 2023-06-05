<form class="" action="/billing" method="get">
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Customer Name" value="{{isset($data['name']) ? $data['name'] : ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="phone" class="form-control" placeholder="Customer Phone" value="{{isset($data['phone']) ? $data['phone'] : ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="reg" class="form-control" placeholder="Reg. no" value="{{isset($data['reg']) ? $data['reg'] : ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="remain" class="form-control" placeholder="Remaining MB" value="{{isset($data['remain']) ?  $data['remain'] : ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" data-toggle="datepicker" name="valid" class="form-control" placeholder="Validity" value="{{isset($data['valid']) ? $data['valid'] : ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="submit" class="btn btn-sm btn-primary" name="type" value="search" />
            <input type="submit" class="btn btn-sm btn-info" name="type" value="export" />
        </div>
    </div>
</form>
