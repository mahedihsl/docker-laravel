<template>
  <div style="width: 100%;">
    <spinner v-show="loading" :extra-height="false"></spinner>
    <canvas v-show="!loading && !empty" id="fuel-graph"></canvas>
    <no-data v-show="!loading && empty"></no-data>
  </div>
</template>

<script>
import NoData from '../../util/NoItemFound.vue'
import Spinner from '../../util/Spinner'

export default {
  props: {
    items: {
      type: Object,
      required: true,
    },
    loading: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  components: {
    NoData,
    Spinner,
  },
  computed: {
    empty() {
      return !this.items.values.length
    },
  },
  watch: {
    items(data, old) {
      this.updateChartData(data)
    },
  },
  mounted() {
    this.drawChart()
    this.updateChartData(this.items)
  },
  methods: {
    /**
     * @param data
     * @param data.values daily fuel percentage values
     * @param data.events refuel events
     */
    updateChartData({ values, events }) {
      const eventValues = new Array(values.length).fill(0)
      for (const e of events) {
        const i = values.findIndex(v => v.when === e.when)
        if (i !== -1) {
          eventValues[i] = e.value
        }
      }

      this.chart.data.labels = values.map(el => el.when)
      this.chart.data.datasets[0].data = values.map(el => el.value)
      this.chart.data.datasets[1].data = eventValues
      this.chart.update()
    },
    drawChart() {
      this.chart = new Chart(
        document.getElementById('fuel-graph').getContext('2d'),
        {
          type: 'bar',
          data: {
            labels: [],
            datasets: [
              {
                type: 'line',
                label: '%',
                backgroundColor: '#EF5350',
                borderColor: '#EF5350',
                data: [],
                fill: false,
              },
              {
                type: 'bar',
                label: 'Refuel %',
                backgroundColor: '#3f51b5',
                borderColor: '#3f51b5',
                data: [],
                fill: true,
              },
            ],
          },
          options: {
            responsive: true,
            tooltips: {
              enabled: true,
            },
            legend: {
              display: false,
            },
            scales: {
              xAxes: [
                {
                  stacked: true,
                  barThickness: 20,
                },
              ],
              yAxes: [
                {
                  stacked: true,
                  gridLines: {
                    display: true,
                  },
                  ticks: {
                    beginAtZero: true,
                    min: 0,
                    max: 100,
                    stepSize: 20,
                    callback: (label, index, labels) => label + '%',
                  },
                },
              ],
            },
          },
        }
      )
    },
  },
}
</script>

<style lang="scss" scoped></style>
