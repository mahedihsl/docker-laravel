require('../bootstrap')

import VModal from 'vue-js-modal'

Vue.use(VModal)

import store from './store'
import { mapGetters } from 'vuex'

import GeofenceMap from '../position/GeofenceMap'

import AreaBuilder from './comp/AreaBuilder.vue'
import AreaEditor from './comp/AreaEditor.vue'
import NoAreaFound from './comp/NoAreaFound.vue'
import AreaList from './comp/AreaList.vue'
import TemplateList from './comp/TemplateList.vue'
import GeofenceInfo from './comp/GeofenceInfo.vue'
import TemplateInfo from './comp/TemplateInfo.vue'
import CarChooser from './comp/CarChooser.vue'

new Vue({
  el: '#app',
  store,
  components: {
    NoAreaFound,
    AreaBuilder,
    AreaEditor,
    AreaList,
    TemplateList,
    GeofenceInfo,
    TemplateInfo,
    CarChooser,
  },
  data: {
    map: null,
    userId: 0,
    currentGeofence: null,
    currentTemplate: null,
  },
  computed: {
    ...mapGetters(['geofences', 'templates']),
  },
  mounted() {
    this.userId = document.getElementsByName('customer_id')[0].value

    this.$store.dispatch('fetchCars', this.userId)
    this.$store.dispatch('fetch', this.userId)
    this.$store.dispatch('fetchAllCars')
    this.$store.dispatch('templates')

    this.initMap()
  },
  methods: {
    initMap() {
      try {
        this.map = new GeofenceMap('common-map')
        this.map.init()
      } catch (error) {
        console.log(error)
      }
    },

    onGeofenceClick(geofence) {
      this.currentGeofence = geofence
      this.currentTemplate = null
      this.map.showPolygon(geofence.coordinates)
    },

    onGeofenceEdit() {
      console.log(`showing area editor`)
      this.$modal.show('area-editor')
    },

    onTemplateClick(geofence) {
      this.currentTemplate = geofence
      this.currentGeofence = null
      this.map.showPolygon(geofence.coordinates)
    },

    async onTemplateAdd(template) {
      await this.$store.dispatch('attachTemplate', {
        templateId: template.id,
        userId: this.userId,
      })
    },

    showAreaBuilder() {
      this.$modal.show('area-builder')
    },

    closeAreaBuilder() {
      this.$modal.hide('area-builder')
    },

    closeAreaEditor() {
      this.$modal.hide('area-editor')
    },

    showCarChooser(geofence) {
      this.currentGeofence = geofence
      this.$store.dispatch('fetchSubscriptions', geofence.id)
      this.$modal.show('car-chooser')
    },

    closeCarChooser() {
      this.currentGeofence = null
      this.$modal.hide('car-chooser')
    },
  },
})
