<template lang="html">
  <div class="col-xs-12 col-md-6">
    <div class="info-boxx">
      <h4 class="text-center box-title">GAS METER</h4>
      <div class="content gas-meter" v-show="subscribed">
        <div
          class="gas-level"
          v-for="v in level"
          :key="v"
          :class="{ yellow: v == 1, green: v > 1 }"
        ></div>
        <!-- <canvas class="" id="gas-meter" style="margin-top: 30px;"></canvas> -->
      </div>
      <div class="content" v-show="!subscribed">
        <not-subscribed body="Not subscribed"></not-subscribed>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from '../../../util/EventBus'
import GasApi from '../../../api/GasApi'

import NotSubscribed from '../../util/NotSubscribed.vue'

export default {
  props: ['deviceId', 'subscribed'],
  components: {
    NotSubscribed,
  },
  data: () => ({
    // chart: null,
    level: 0,
  }),
  watch: {
    deviceId: function(newVal, oldVal) {
      this.getLatestGas(newVal)
    },
  },
  mounted() {
    if (this.subscribed) {
      // EventBus.$on('latest-gas-found', this.onLatestGasData.bind(this))
      // this.drawChart();
      this.getLatestGas(this.deviceId)
    }
  },
  methods: {
    async getLatestGas(id) {
      let api = new GasApi(EventBus)
      const data = await api.latestAsync(id)
      this.level = +data.value + 1
      console.log(`gas level updated`, this.level)
    },
    // onLatestGasData(item) {
    //   console.log(`latest gas`, item)

    //   this.level = +item.value + 1
    //   console.log(`gas level`, this.level)

    //   // this.chart.data.datasets = this.getChartData(item.value);
    //   // this.chart.update();
    // },
    // drawChart() {
    //   this.chart = new Chart(document.getElementById("gas-meter").getContext("2d"), {
    //     type: 'bar',
    //     data: {
    //       labels: ["Today"],
    //       datasets: [],
    //     },
    //     options: {
    //       tooltips: {
    //         enabled: false
    //       },
    //       legend: {
    //         display: false,
    //       },
    //       scales: {
    //         xAxes: [{
    //           stacked: true,
    //           barThickness: 20,
    //         }],
    //         yAxes: [{
    //           stacked: true,
    //           gridLines : {
    //             display : false
    //           },
    //           ticks: {
    //             callback: (label, index, labels) => ''
    //           },
    //         }]
    //       }
    //     }
    //   });
    // },
    // getChartData(value) {
    //   let ret = [{
    //       backgroundColor: '#FDD835',
    //       data: [1]
    //   }];
    //   for (var i = 1; i < 5; i++) {
    //     ret.push({
    //       backgroundColor: 'white',
    //       data: [.5]
    //     });
    //     ret.push({
    //       backgroundColor: i <= value ? '#66BB6A' : 'white',
    //       data: [1]
    //     });
    //   }
    //   return ret;
    // },
  },
}
</script>

<style lang="css" scoped>
.gas-meter {
  display: flex;
  flex-direction: column-reverse;
  justify-content: flex-start;
  align-items: center;
}
.gas-level {
  width: 32px;
  height: 36px;
  border-radius: 4px;
  margin-bottom: 8px;

  -webkit-box-shadow: 0px 5px 5px 0px rgba(64, 64, 64, 0.2);
  -moz-box-shadow: 0px 5px 5px 0px rgba(64, 64, 64, 0.2);
  box-shadow: 0px 5px 5px 0px rgba(64, 64, 64, 0.2);
}
.yellow {
  background-color: #fdd835;
}
.green {
  background-color: #66bb6a;
}
</style>
