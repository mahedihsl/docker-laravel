<form class="" action="/bkash/allbill" method="get">
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
                <input type="text" name="wallet" class="form-control" placeholder="bKash Wallet No" value="{{$data['wallet'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="car" class="form-control" placeholder="Car no" value="{{$data['car'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="submit" class="btn btn-sm btn-primary" name="type" value="search" />
        </div>
    </div>
</form>
