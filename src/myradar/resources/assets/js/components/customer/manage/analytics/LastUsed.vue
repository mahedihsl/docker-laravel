<template>

    <div class="col-xs-12">
      <div class="topcard card">
        <div class="cardleftbar col-xs-6 col-sm-6 col-md-4 col-lg-4" >
          <i class="fa fa-line-chart clockicon" style="display: block;" aria-hidden="true"></i>
        </div>
        <div class="top col-xs-6 col-sm-6 col-md-4 col-lg-4" >
          <div>
            <h4>API Request</h4>
          </div>
          <div>
            <table class="table table-responsive">
              <thead>
                <tr>
                  <th>Today</th>
                  <th>Yesterday</th>
                  <th>Before Yest.</th>
                  <th>Day 4</th>
                  <th>Day 5</th>
                  <th>Day 6</th>
                  <th>Day 7</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center">{{stat[0]}}</td>
                  <td class="text-center">{{stat[1]}}</td>
                  <td class="text-center">{{stat[2]}}</td>
                  <td class="text-center">{{stat[3]}}</td>
                  <td class="text-center">{{stat[4]}}</td>
                  <td class="text-center">{{stat[5]}}</td>
                  <td class="text-center">{{stat[6]}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import AnalyticsApi from '../../../../api/AnalyticsApi';

export default{
  props: ["customer"],
  data: () => ({
    stat: [0, 0, 0, 0, 0, 0, 0],
  }),
  mounted() {
    AnalyticsApi.getRequestStats(this.customer).then(stat => {this.stat = stat});
  }
}
</script>

<style lang="scss" scoped>
.clockicon{
  font-size: 50px;
  position: relative;
  top: 50%;
  left: 35%;
  transform: translate(-50%, -50%) !important;
}
.top{
  padding:0px;
  padding-left: 5%;
}
.top h2{
  margin:0px;
}
</style>
