<style>

</style>
<div id="day_wise_driving_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                  <div class="col-md-12">
                  <div class="col-md-6">
                  <div id="day_wise_driving_hour_modal_title"></div>
                </div>
                <div class="col-md-6">
                <select id="date_range_selection" class="form-control" name="">
                
                  <option value="30">30 Days</option>
                  <option value="25">25 Days</option>
                  <option value="20">20 Days</option>
                  <option value="10">10 Days</option>
                  <option value="7">7 Days</option>
                  </select>
                </div>
                </div>
                  <div id="day_wise_driving_modal_owner_name"></div>
                  <div id="day_wise_driving_modal_car_reg_no"></div>
                  <div id="day_wise_driving_modal_car_driver_name"></div>
                </h4>
            </div>
            <div class="modal-body">

                  <canvas id="bar_chart_driving_hour" width="800" height="400"></canvas>

               </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button>

            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>

</script>
