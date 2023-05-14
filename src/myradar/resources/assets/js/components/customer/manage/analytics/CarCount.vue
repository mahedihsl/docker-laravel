<template>

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <div class="topcard card">
        <div class="cardleftbar col-xs-6 col-sm-6 col-md-4 col-lg-4" >
          <i class="fa fa-line-chart caricon"></i>
        </div>
        <div class="top col-xs-6 col-sm-6 col-md-8 col-lg-8" >
          <div>
            <h4 >App Open</h4>
          </div>
          <div>
            <table class="table table-responsive">
              <thead>
                <tr>
                  <th>Today</th>
                  <th>Yesterday</th>
                  <th>Before Yest.</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center">{{stat[0]}}</td>
                  <td class="text-center">{{stat[1]}}</td>
                  <td class="text-center">{{stat[2]}}</td>
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
    stat: [0, 0, 0],
  }),
  mounted() {
    AnalyticsApi.getLoginStats(this.customer).then(stat => {this.stat = stat});
  }
}
</script>


<style lang="scss" scoped>
.carcounttitle{
  font-size: 25px;
}
.caricon{
  font-size : 40px;
  position:relative;
  top: 50%;
  left: 38%;
  transform: translate(-50%, -50%) !important;
}

.top{
    display: inline;
    padding-left:5%;

}
.top h4{
  margin:0px;
}
.top h2{
  margin:0px;
  margin-bottom: 3%;
}

</style>
