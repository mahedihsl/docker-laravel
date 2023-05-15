<template lang="html">
    <div class="col-xs-12 col-md-6">
      <div class="info-boxx large-box">
        <div class="col-xs-12 col-md-6" style="padding-top: 10px;">
            <span class="box-title">MILEAGE REPORT</span>
        </div>
        <div class="col-xs-12 col-md-6" style="display: flex; flex-direction: row; justify-content: end; align-items: center;">
            <div>
              <span v-if="total" class="total-value">
                Total - {{ total }} Km
              </span>
            </div>
            <div class="select-style" v-show="subscribed">
                <select v-model="days">
                    <option value="5">Last 5 Days</option>
                    <option value="10">Last 10 Days</option>
                    <option value="15">Last 15 Days</option>
                    <option value="20">Last 20 Days</option>
                    <option value="25">Last 25 Days</option>
                    <option value="30">Last 30 Days</option>
                    <option value="60">Last 2 Months</option>
                    <option value="90">Last 3 Months</option>
                </select>
            </div>
        </div>
        <div class="content" v-show="subscribed">
            <spinner v-show="loading" :extra-height="false"></spinner>
            <canvas v-show="!loading && !empty" id="mileage-chart"></canvas>
            <no-data v-show="!loading && empty"></no-data>
        </div>
        <div class="content" v-show="!subscribed">
          <not-subscribed body="Not subscribed" :extra-height="true"></not-subscribed>
        </div>
      </div>
    </div>
</template>

<script>
import EventBus from '../../../util/EventBus';
import MileageApi from '../../../api/MileageApi';

import NotSubscribed from '../../util/NotSubscribed.vue';
import NoData from '../../util/NoItemFound.vue';
import Spinner from '../../util/Spinner.vue';

export default {
  props: ['carId', 'subscribed'],
  components: {Spinner, NoData, NotSubscribed},
  data: () => ({
    chart: null,
    days: '5',
    empty: false,
    loading: true,
    total: 0,
  }),
  watch: {
    days: function(newVal, oldVal) {
      this.getMilaegeData(this.carId, newVal);
    },
    carId: function(newVal, oldVal) {
      this.getMilaegeData(newVal, this.days);
    }
  },
  mounted() {
    if (this.subscribed) {
      EventBus.$on('mileage-data-found', this.onMileageData.bind(this));
      this.drawChart();
      this.getMilaegeData(this.carId, this.days);
    }
  },
  methods: {
    onMileageData(list) {
      this.loading = false;
      this.empty = !list.length;
      if (list.length) {
        this.total = list.reduce((sum, item) => sum + item.value, 0).toFixed(1)
        let max = _.maxBy(list, o => o.value);
        this.chart.data.labels = list.map(el => el.date);
        this.chart.data.datasets[0].data = list.map(el => el.value);
        this.chart.options.scales.yAxes[0].ticks.max = Math.ceil(max.value + 5);
        this.chart.update();
      }
    },
    getMilaegeData(id, days) {
      this.loading = true;
      let api = new MileageApi(EventBus);
      api.getRecords(id, days);
    },
    drawChart() {
      this.chart = new Chart(document.getElementById("mileage-chart").getContext("2d"), {
          type: 'line',
          data: {
            labels: [],
            datasets: [{
              label: "KM",
              backgroundColor: '#4CAF50',
              borderColor: '#4CAF50',
              data: [],
              fill: false,
            }]
          },
          options: {
            tooltips: {
              enabled: true
            },
            legend: {
              display: false,
            },
            scales: {
              xAxes: [{
                stacked: true,
                barThickness: 20,
              }],
              yAxes: [{
                stacked: true,
                gridLines : {
                  display : true
                },
                ticks: {
                  beginAtZero: true,
                  min: 0,
                  max: 100,
                  stepSize: 100,
                  callback: (label, index, labels) => (label + ' km')
                }
              }]
            }
          }
      });
    }
  }
}
</script>

<style lang="css">
.total-value {
  background-color: #f5f5f5;
  border-radius: 4px;
  padding: 5px 12px;
  color: #616161;
  font-size: 14px;
  margin-right: 8px;
  font-weight: 600;
}
</style>
