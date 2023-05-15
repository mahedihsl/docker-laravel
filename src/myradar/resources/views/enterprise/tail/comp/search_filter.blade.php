<form class="tail-form" action="/enterprise/tail/result" method="get">
    <div class="row">
        <div class="col-sm-5 col-md-offset-0">
            <div class="form-group">
              <select id="report_type" class="form-control" name="report_type">
                <option value="1">Mileage</option>
                <option value="2">Driving Hour</option>
                <option value="3">Duty Hour </option>
                <option value="4">Fuel Consumption</option>
                <option value="5">Mileage Per Litre</option>
                <option value="6">Mileage per 100 tk</option>
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
              <select id="comparsion_value" class="form-control" name="comparsion_value" placeholder="">
                <option value="1"> =< </option>
                <option value="2"> >= </option>
                <option value="4"> Min </option>
                <option value="5"> Max </option>
                </select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="number" id="filter_value" class="form-control" name="filter_value" placeholder="value"/>
            </div>
        </div>
  </div></br></br>
        <div class="col-sm-2 col-md-offset-4">
            <input type="submit" class="btn btn-md btn-primary" name="search" value="Search" />
              <a class="btn btn-sm btn-default" href="/enterprise/tail/report"><i class="fa fa-refresh fa-1x"></i></a>
        </div>

</form>
