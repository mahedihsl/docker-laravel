<template>
  <div class="row modal-body">
    <div
      class="col-xs-12 spacing"
      id="chooser-header"
      style="flex-shrink: 0; display: flex; flex-direction: row; align-items: center;"
    >
      <h4 class="text-dark" style="flex-grow: 1;">
        Assign Geofence: <strong>{{ geofence.name }}</strong>
      </h4>
      <div style="flex-shrink: 0; width: 30%;">
        <input
          type="text"
          class="form-control"
          v-model="query"
          placeholder="Search Car"
        />
      </div>
    </div>
    <div
      class="col-xs-12 builder-content"
      style="flex-grow: 1; overflow: scroll;"
    >
      <div class="input-wrapper" style="overflow: scroll;">
        <table class="table table-responsive table-striped">
          <thead>
            <tr>
              <th class="col-xs-4">
                <input type="checkbox" v-model="selectAll" id="selectall" />
                <label for="selectall" style="margin-left: 10px;"
                  >Select All</label
                >
              </th>
              <th class="col-xs-8">Car Number</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(car, i) in filteredCars" :key="i">
              <td>
                <input type="checkbox" v-model="car.selected" />
              </td>
              <td>{{ car.reg_no }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-xs-12 spacing" style="flex-shrink: 0;">
      <button class="btn btn-success pull-right ml-6" @click="save">
        <i class="fa fa-check"></i>
        Save
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
import { mapGetters } from 'vuex'

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
    query: '',
    cars: [],
    loading: false,
    selectAll: false,
  }),
  computed: {
    ...mapGetters(['allCars']),
    filteredCars() {
      const search = this.query.trim()
      if (!search) return this.cars
      return this.cars.filter(car => car.reg_no.indexOf(search) > -1)
    },
  },
  watch: {
    allCars: {
      handler(val, old) {
        this.cars = [...val]
      },
      immediate: true,
    },
    selectAll(val, old) {
      this.cars = this.cars.map(car => ({ ...car, selected: !!val }))
    },
  },
  mounted() {},
  methods: {
    async save() {
      this.loading = true
      let selectedCars = [
        ...this.filteredCars.filter(car => car.selected),
        ...this.cars.filter(car => car.selected),
      ]
      selectedCars = [...new Set(selectedCars.map(c => c.id))]

      await this.$store.dispatch('syncSubscriptions', {
        geofence_id: this.geofence.id,
        car_ids: selectedCars,
      })
      this.$emit('cancel')
    },
  },
}
</script>

<style scoped>
.modal-body {
  position: relative;
  z-index: 1000;
  overflow: auto;
  height: 100%;
  display: flex;
  flex-direction: column;
}

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
