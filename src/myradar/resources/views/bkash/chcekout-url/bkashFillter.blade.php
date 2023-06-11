<form class="" action="/bkash/allbill" method="get">
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Customer Name" value="{{$data['user_name'] or ''}}">
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
                <input type="text" name="reg" class="form-control" placeholder="Car no" value="{{$data['car_no'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="remain" class="form-control" placeholder="bKash Wallet No" value="{{$data['bkash_wallet_no'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="submit" class="btn btn-sm btn-primary" name="type" value="search" />
        </div>
    </div>
</form>
