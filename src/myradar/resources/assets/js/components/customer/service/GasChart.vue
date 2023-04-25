<template lang="html">
  <div class="col-xs-12 col-md-6">
    <div class="info-boxx large-box">
      <div class="col-xs-6 col-md-8" style="padding-top: 10px;">
        <span class="box-title">GAS HISTORY</span>
      </div>
      <div class="col-xs-6 col-md-4">
        <div class="select-style pull-right">
          <select v-model="days">
            <option value="5">Last 5 Days</option>
            <option value="10">Last 10 Days</option>
            <option value="15">Last 15 Days</option>
          </select>
        </div>
      </div>
      <div class="content">
        <spinner v-show="loading" :extra-height="true"></spinner>
        <canvas v-show="!loading" id="gas-graph"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import EventBus from '../../../util/EventBus';
import GasApi from '../../../api/GasApi';

import Spinner from '../../util/Spinner';

export default {
  props: ['deviceId'],
  components: {Spinner},
  data: () => ({
    chart: null,
    days: '5',
    loading: true,
  }),
  watch: {
    days: function(newVal, oldVal) {
      this.getGasData(this.deviceId, newVal);
    },
    deviceId: function(newVal, oldVal) {
      this.getGasData(newVal, this.days);
    }
  },
  mounted() {
    EventBus.$on('gas-chart-found', this.onDataFound.bind(this));

    this.drawChart();

    this.getGasData(this.deviceId, this.days);
  },
  methods: {
    onDataFound(list) {
      console.log('gas data found', list);
      this.loading = false;
      this.chart.data.labels = list.map(el => el.when);
      this.chart.data.datasets = this.getChartData(list);
      this.chart.update();
    },
    getGasData(id, days) {
      this.loading = true;
      let api = new GasApi(EventBus);
      api.history(id, days);
    },
    drawChart() {
      this.chart = new Chart(document.getElementById("gas-graph").getContext("2d"), {
        type: 'bar',
        data: {
          labels: [],
          datasets: [],
        },
        options: {
          responsive: true,
          tooltips: {
            enabled: false
          },
          legend: {
            display: false,
          },
          scales: {
            xAxes: [{
              stacked: true,
              barThickness: 25,
            }],
            yAxes: [{
              stacked: true,
              gridLines : {
                display : false
              },
              ticks: {
                callback: (label, index, labels) => ''
              },
            }]
          }
        }
      });
    },

    getChartData(items) {
      let result = [];
      for(var i = 0; i < 5; i++) {
        result.push({
          backgroundColor: this.getRowColor(items, i),
          data: this.getChartRow(items, i),
        });
        result.push({
          backgroundColor: 'white',
          data: items.map(item => .5),
        });
      }
      return result;
    },

    getChartRow(items, i) {
      return items.map(el => i <= el.value ? 1 : 1);
    },

    getRowColor(items, i) {
      if (i === 0) {
        return '#FDD835';
      }
      for (var k = 0; k < items.length; k++) {
        if (i <= items[k].value) {
          return '#66BB6A';
        }
      }
      return 'white';
    }
  }
}
</script>

<style lang="css">
</style>
