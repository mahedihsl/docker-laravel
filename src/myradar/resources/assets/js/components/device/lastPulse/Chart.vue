<template>
  <canvas id="perf-chart"></canvas>
</template>
<script>
import EventBus from '../../../util/EventBus';

export default {
  data: () => ({

  }),
  computed: {

  },
  mounted() {
    EventBus.$on('perf-stats-found', this.draw.bind(this));

    setTimeout(() => {
      this.$store.dispatch('getStats')
    }, 300);
  },
  methods: {
    draw(data) {
			new Chart(document.getElementById('perf-chart').getContext('2d'), {
				type: 'bar',
				data: {
    			labels: [],
    			datasets: [
            {
      				label: 'Good',
      				backgroundColor: '#4caf50',
      				borderColor: '#1b5e20',
      				borderWidth: 1,
      				data: [data.good]
			     },
           {
    				label: 'Bad',
    				backgroundColor: '#ffc107',
    				borderColor: '#ff8f00',
    				borderWidth: 1,
    				data: [data.bad]
    			},
          {
           label: 'Worst',
           backgroundColor: '#f44336',
           borderColor: '#c62828',
           borderWidth: 1,
           data: [data.worst]
         }
        ]

    		},
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Device Performance Chart'
					}
				}
			});
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
