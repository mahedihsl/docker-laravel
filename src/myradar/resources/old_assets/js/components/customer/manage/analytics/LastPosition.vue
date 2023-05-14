<template>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="bottomcard card">
      <div class="vehiclestitle col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h4>Last Position</h4>
      </div>
      <div
        class="card-content col-xs-12 col-sm-12 col-md-12 col-lg-12"
        id="gmap"
      ></div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data: () => ({
    map: null,
    marker: null,
  }),
  computed: {
    ...mapGetters('car', ['location']),
  },
  watch: {
    location(val, old) {
      if (this.marker) {
        this.marker.setMap(null)
      }
      if (this.map && val) {
        this.createMarker(val)
      }
    },
  },
  mounted() {
    this.initMap()
  },
  methods: {
    initMap() {
      this.map = new google.maps.Map(document.getElementById('gmap'), {
        zoom: 13,
        center: { lat: 23.837139, lng: 90.367264 },
        gestureHandling: 'greedy',
      })

      google.maps.event.addListenerOnce(this.map, 'idle', this.onMapReady.bind(this))
    },

    onMapReady() {
      if (this.location) {
        this.createMarker(this.location)
      }
    },

    createMarker(location) {
      this.marker = new google.maps.Marker({
        position: { lat: location.lat, lng: location.lng },
        map: this.map,
      })
      this.map.panTo(new google.maps.LatLng(location.lat, location.lng))
    },
  },
}
</script>

<style lang="scss" scoped>
</style>
