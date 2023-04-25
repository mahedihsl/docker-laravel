<template lang="html">
    <div class="col-xs-12 col-md-6">
      <div class="info-boxx large-box">
        <div class="col-xs-6 col-md-8" style="padding-top: 10px;">
            <span class="box-title">FUEL HISTORY</span>
        </div>
        <div class="col-xs-6 col-md-4">
            <div class="select-style pull-right" v-show="subscribed">
                <select v-model="days">
                    <option value="5">Last 5 Days</option>
                    <option value="10">Last 10 Days</option>
                    <option value="15">Last 15 Days</option>
                </select>
            </div>
        </div>
        <div class="content" v-show="subscribed">
            <spinner v-show="loading" :extra-height="false"></spinner>
            <canvas v-show="!loading && !empty" id="fuel-graph"></canvas>
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
import FuelApi from '../../../api/FuelApi';

import NotSubscribed from '../../util/NotSubscribed.vue';
import NoData from '../../util/NoItemFound.vue';
import Spinner from '../../util/Spinner';

export default {
  props: ['deviceId', 'subscribed'],
  components: {Spinner, NoData, NotSubscribed},
  data: () => ({
    chart: null,
    days: '5',
    empty: false,
    loading: true,
  }),
  watch: {
    days: function(newVal, oldVal) {
      this.getFuelData(this.deviceId, newVal);
    },
    deviceId: function(newVal, oldVal) {
      this.getFuelData(newVal, this.days);
    }
  },
  mounted() {
    if (this.subscribed) {
      EventBus.$on('fuel-chart-found', this.onDataFound.bind(this));
      this.drawChart();
      this.getFuelData(this.deviceId, this.days);
    }
  },
  methods: {
    onDataFound(list) {
      this.loading = false;
      this.empty = !list.length;
      if (!this.empty) {
        this.chart.data.labels = list.map(el => el.when);
        this.chart.data.datasets[0].data = list.map(el => el.value);
        this.chart.update();
      }
    },
    getFuelData(id, days) {
      this.loading = true;
      let api = new FuelApi(EventBus);
      api.history(id, days);
    },
    drawChart() {
      this.chart = new Chart(document.getElementById("fuel-graph").getContext("2d"), {
        type: 'line',
        data: {
          labels: [],
          datasets: [{
            label: "%",
            backgroundColor: '#EF5350',
            borderColor: '#EF5350',
            data: [],
            fill: false,
          }]
        },
        options: {
          responsive: true,
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
                stepSize: 20,
                callback: (label, index, labels) => (label + '%')
              },
            }]
          }
        }
      });
    }
  }
}
</script>

<style lang="css">
</style>
