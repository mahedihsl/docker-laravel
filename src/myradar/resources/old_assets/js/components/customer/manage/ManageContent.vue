<template>
  <div class="col-xs-12 col-md-10">
    <component
      v-bind:is="current"
      :customer="customer"
      :meta="meta"
    ></component>
  </div>
</template>
<script>
import EventBus from '../../../util/EventBus'

import Analytics from './analytics/Analytics.vue'
import Account from './account/Account.vue'
import Vehicles from './vehicle/Vehicles.vue'
import Payment from './payment/Payment.vue'
import Settings from './settings/Settings.vue'
import Promotion from './promotion/Promotion.vue'
import RmsManager from './rms/RmsManager.vue'

export default {
  components: {
    Analytics,
    Account,
    Vehicles,
    Payment,
    Settings,
    Promotion,
    RmsManager,
  },
  data: () => ({
    meta: null,
    current: null,
    customer: null,
  }),
  computed: {},
  mounted() {
    EventBus.$on('menu-clicked', this.onMenuClicked.bind(this))
  },
  methods: {
    onMenuClicked(tag, customer, meta) {
      this.meta = meta
      this.customer = customer
      let comps = [
        'analytics',
        'account',
        'vehicles',
        'payment',
        'settings',
        'promotion',
        'rms-manager',
      ]
      if (comps.indexOf(tag) > -1) {
        this.current = tag
      }
    },
  },
}
</script>
<style lang="scss" scoped>
</style>
