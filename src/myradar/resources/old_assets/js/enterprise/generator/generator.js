require('../../bootstrap')

import store from './store'
import { mapGetters } from 'vuex'

import EmptyBox from '../../components/util/EmptyBox.vue'
import FuelMeter from '../../components/customer/service/FuelMeter.vue'
import FuelGraph from '../../components/customer/service/FuelGraph.vue'

new Vue({
  el: '#app',
  store,
  components: {
    EmptyBox,
    FuelMeter,
    FuelGraph,
  },
  data: {
    chartType: 'daily',
  },
  computed: {
    ...mapGetters(['generators', 'fuel', 'history']),
  },
  mounted() {
    this.initialize()
  },
  methods: {
    async initialize() {
      await this.$store.dispatch('fetch')

      this.fetchFuelValue()
      this.fetchFuelHistory()

      setInterval(this.fetchFuelValue.bind(this), 10000)
      setInterval(this.fetchFuelHistory.bind(this), 60000)
    },

    fetchFuelValue() {
      if (this.generators.length) {
        this.$store.dispatch('fetchFuel', this.generators[0].id)
      }
    },

    fetchFuelHistory() {
      if (this.generators.length) {
        this.$store.dispatch('fetchHistory', {
          car_id: this.generators[0].id,
          type: this.chartType,
        })
      }
    },
  },
})
