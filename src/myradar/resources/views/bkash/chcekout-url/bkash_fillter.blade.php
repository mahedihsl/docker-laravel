<form class="" action="/bkash/allbill" method="get">
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
                <input type="text" name="wallet" class="form-control" placeholder="bKash Wallet No" value="{{isset( $data['wallet']) ? $data['wallet'] : ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="trx_id" class="form-control" placeholder="bKash trxID" value="{{isset($data['trx_id']) ? $data['trx_id'] : ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="submit" class="btn btn-sm btn-primary" name="type" value="search" />
        </div>
    </div>
</form>
