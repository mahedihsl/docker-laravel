<template>
  <div class="col-xs-12">
    <canvas id="canvas"></canvas>
  </div>
</template>
<script>
import EventBus from '../../util/EventBus'

export default {
  props: ['type', 'car'],
  data: () => ({
    label: '',
    items: [],
    labels: [],
  }),
  mounted() {
    EventBus.$on('chart-report-found', this.onReportFound.bind(this))

    let names = ['Driving Hour per Day', 'Duty Hour per Day', 'Mileage per Day']
    this.label = names[parseInt(this.type) - 1]
  },
  updated() {
    console.log('chart update called')
  },
  methods: {
    onReportFound(id, list) {
      console.log('report found, ', list.length)
      if (this.car.id == id) {
        this.labels = []
        this.items = []
        for (let i = 1; i <= 31; i++) {
          let k = list.findIndex(o => o.day == i)
          this.labels.push(`${i}`)
          this.items.push(k != -1 ? list[k].val : 0)
        }
        this.drawChart()
      }
    },
    drawChart() {
      let ctx = document.getElementById('canvas').getContext('2d')

      // Chart.plugins.register({
      //   beforeRender: function(chart) {
      //     if (chart.config.options.showAllTooltips) {
      //       // create an array of tooltips
      //       // we can't use the chart tooltip because there is only one tooltip per chart
      //       chart.pluginTooltips = []
      //       chart.config.data.datasets.forEach(function(dataset, i) {
      //         chart.getDatasetMeta(i).data.forEach(function(sector, j) {
      //           chart.pluginTooltips.push(
      //             new Chart.Tooltip(
      //               {
      //                 _chart: chart.chart,
      //                 _chartInstance: chart,
      //                 _data: chart.data,
      //                 _options: chart.options.tooltips,
      //                 _active: [sector],
      //               },
      //               chart
      //             )
      //           )
      //         })
      //       })

      //       // turn off normal tooltips
      //       chart.options.tooltips.enabled = false
      //     }
      //   },
      //   afterDraw: function(chart, easing) {
      //     if (chart.config.options.showAllTooltips) {
      //       // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
      //       if (!chart.allTooltipsOnce) {
      //         if (easing !== 1) return
      //         chart.allTooltipsOnce = true
      //       }

      //       // turn on tooltips
      //       chart.options.tooltips.enabled = true
      //       Chart.helpers.each(chart.pluginTooltips, function(tooltip) {
      //         // This line checks if the item is visible to display the tooltip
      //         if (!tooltip._active[0].hidden) {
      //           tooltip.initialize()
      //           tooltip.update()
      //           // we don't actually need this since we are not animating tooltips
      //           tooltip.pivot()
      //           tooltip.transition(easing).draw()
      //         }
      //       })
      //       chart.options.tooltips.enabled = false
      //     }
      //   },
      // })

      Chart.plugins.register({
        afterDraw: function(chartInstance) {
          if (chartInstance.config.options.showDatapoints) {
            var helpers = Chart.helpers
            var ctx = chartInstance.chart.ctx
            var fontColor = helpers.getValueOrDefault(
              chartInstance.config.options.showDatapoints.fontColor,
              chartInstance.config.options.defaultFontColor
            )

            // render the value of the chart above the bar
            ctx.font = Chart.helpers.fontString(
              Chart.defaults.global.defaultFontSize,
              'normal',
              Chart.defaults.global.defaultFontFamily
            )
            ctx.textAlign = 'center'
            ctx.textBaseline = 'bottom'
            ctx.fillStyle = fontColor

            chartInstance.data.datasets.forEach(function(dataset) {
              for (var i = 0; i < dataset.data.length; i++) {
                var model =
                  dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model
                var scaleMax =
                  dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale
                    .maxHeight
                var yPos =
                  (scaleMax - model.y) / scaleMax >= 0.93
                    ? model.y + 20
                    : model.y - 5
                ctx.fillText(dataset.data[i], model.x, yPos)
              }
            })
          }
        },
      })

      let instance = this
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: this.labels,
          datasets: [
            {
              label: this.label,
              backgroundColor: this.getBarColor(),
              borderColor: this.getBorderColor(),
              borderWidth: 1,
              data: this.items,
            },
          ],
        },
        options: {
          responsive: true,
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: this.getTitle(),
          },
          tooltips: {
            enabled: true,
            callbacks: {
              title: function(tooltipItems, data) {
                return `${tooltipItems[0].xLabel} ${instance.car.info.month}`
              },
              label: function(tooltipItem, data) {
                let val = tooltipItem.yLabel
                let unit = instance.type == 3 ? 'Km' : 'Hour'
                let suffix = val > 1 && instance.type != 3 ? 's' : ''
                return `${val} ${unit}${suffix}`
              },
            },
          },
          // showAllTooltips: true,
          showDatapoints: true,

        },
      })
    },

    getTitle() {
      let names = ['Driving Hour', 'Duty Hour', 'Mileage Report']
      let driver = this.car.driver ? this.car.driver.name : '--'
      return `${names[parseInt(this.type) - 1]} of ${driver}, Car: ${
        this.car.name
      } (${this.car.info.month})`
    },

    getBarColor() {
      let colors = ['#42A5F5', '#66BB6A', '#26A69A']
      return colors[parseInt(this.type) - 1]
    },

    getBorderColor() {
      let colors = ['#1E88E5', '#43A047', '#00897B']
      return colors[parseInt(this.type) - 1]
    },
  },
}
</script>
<style lang="scss" scoped>
canvas {
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
}
</style>
