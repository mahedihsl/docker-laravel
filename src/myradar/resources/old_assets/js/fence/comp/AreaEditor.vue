<template>
  <div class="row" style="position: relative; z-index: 1000;">
    <div class="col-xs-12 spacing" id="editor-header">
      <h4 class="text-dark">Edit Geofence - {{ geofence.name }}</h4>
      <button class="btn btn-default btn-manual" @click="showManual = true">
        <i class="fa fa-question-circle-o mr-4"></i>
        How It Works
      </button>
    </div>
    <div class="col-xs-12 builder-content">
      <div class="how-it-works" v-show="showManual">
        <button
          class="btn btn-default btn-sm btn-close-manual"
          @click="showManual = false"
        >
          <i class="fa fa-times"></i>
        </button>
        <label for="">How It Works ?</label>
        <ul>
          <li>Give a meaningful name to your geofence</li>
          <li>Click on the map to add a pin</li>
          <li>You can add multiple pin to the map</li>
          <li>You can drag a pin to change geofence area</li>
          <li>Click an existing pin to remove from map</li>
        </ul>
      </div>
      <div class="form-group input-wrapper">
        <label for="name">Name of the Geofence</label>
        <input
          type="text"
          class="form-control"
          v-model="name"
          placeholder="Ex: Dhanmondi"
        />
        <div class="error-wrapper">
          <p v-for="(e, i) in errors" :key="i" class="text-danger single-error">
            <i class="fa fa-exclamation-circle mr-4"></i> {{ e }}
          </p>
        </div>
      </div>
      <div id="map-container"></div>
    </div>
    <div class="col-xs-12 spacing">
      <button class="btn btn-success pull-right ml-6" @click="save">
        <i class="fa fa-check"></i>
        Save Changes
      </button>
      <button class="btn btn-default pull-right" @click="$emit('cancel')">
        <i class="fa fa-times"></i>
        Close
      </button>
    </div>

    <saving-spinner v-if="loading"></saving-spinner>
  </div>
</template>

<script>
import GeofenceMap from '../../position/GeofenceMap'

import SavingSpinner from './SavingSpinner'

export default {
  props: {
    geofence: {
      type: Object,
      required: true,
    },
  },
  components: {
    SavingSpinner,
  },
  data: () => ({
    name: '',
    errors: [],
    map: null,
    loading: false,
    showManual: false,
  }),
  watch: {
    geofence(model, old) {
      this.setGeofenceInfo(model)
    },
  },
  mounted() {
    this.map = new GeofenceMap('map-container')
    this.map.init()
    this.setGeofenceInfo(this.geofence)
  },
  methods: {
    setGeofenceInfo(model) {
      if (model) {
        this.name = model.name
        if (this.map) {
          for (const c of model.coordinates) {
            this.map.addPin(new google.maps.LatLng(c[1], c[0]))
          }
        }
      }
    },
    async save() {
      if (this.validate()) {
        this.loading = true
        await this.$store.dispatch('update', {
          id: this.geofence.id,
          name: this.name,
          coordinates: this.map.coordinates(),
        })
        // await this.$store.dispatch('fetch', userId)
        await this.$store.dispatch('templates')
        this.$emit('cancel')
      }
    },

    validate() {
      this.errors = []
      let validationStatus = true
      if (this.name.length < 3) {
        this.errors.push('Name must be at least 4 characters long')
        validationStatus = false
      }
      if (!this.map.isPolygonDefined()) {
        this.errors.push('Click on the map to define an area for the Geofence')
        validationStatus = false
      }
      return validationStatus
    },
  },
}
</script>

<style scoped>
.btn-manual {
  position: absolute;
  right: 40px;
  top: 50%;
  transform: translateY(-50%);
}
.btn-close-manual {
  position: absolute;
  right: 20px;
  top: 20px;
}
.input-wrapper,
.how-it-works {
  width: 90%;
  margin: 20px auto;
}
.how-it-works {
  position: relative;
  background: #f5f5f5;
  border: 1px solid #e0e0e0;
  color: #424242;
  border-radius: 5px;
  padding: 20px;
}
.how-it-works > label {
  font-weight: 700;
  font-size: 1.5rem;
}
.how-it-works > p {
  font-weight: 500;
  font-size: 1rem;
}
.how-it-works > ul {
  font-size: 1.2rem;
}
.spacing {
  padding: 10px 30px !important;
}
.builder-content {
  border-top: 1px solid #eeeeee;
  border-bottom: 1px solid #eeeeee;
}
#map-container {
  min-height: 350px;
  background: #f5f5f5;
}
#builder-header {
  cursor: move;
  position: relative;
}
.error-wrapper {
  margin: 10px 0;
}
.single-error {
  margin: 0 !important;
}
</style>
