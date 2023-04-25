<template>
  <div class="row">
    <div class="row header">
      <div class="col-md-12">
        <h4 class="text-center text-primary">
          Update Car: {{ vehicle.reg_no }}
        </h4>
        <hr />
      </div>
    </div>
    <div class="col-md-8 col-md-offset-2">
      <div class="form">
        <div class="col-xs-6">
          <div class="form-group">
            <label>Name <span class="text-maroon">*</span></label>
            <input
              type="text"
              v-model="info.name"
              class="form-control"
              placeholder="ex: Toyota"
            />
            <span class="helper-text text-danger">{{ error.name }}</span>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>Model <span class="text-maroon">*</span></label>
            <input
              type="text"
              v-model="info.model"
              class="form-control"
              placeholder="ex: 2012"
            />
            <span class="helper-text text-danger">{{ error.model }}</span>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>Reg No. <span class="text-maroon">*</span></label>
            <input
              type="text"
              v-model="info.reg_no"
              class="form-control"
              placeholder="ex: Dhaka-Ka xx-xxxx"
            />
            <span class="helper-text text-danger">{{ error.reg_no }}</span>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>Type</label>
            <select class="form-control" v-model="info.type">
              <option value="1">Car</option>
              <option value="2">Van</option>
              <option value="3">Bike</option>
              <option value="4">Bus</option>
              <option value="5">Generator</option>
              <option value="6">RMS</option>
              <option value="7">BIWTA Vessel</option>
              <option value="8">Private Vessel</option>
            </select>
          </div>
        </div>
        <div class="col-xs-6" v-if="info.type == 5">
          <div class="form-group">
            <label>Fuel Tank Volume (in Litre)</label>
            <input
              type="number"
              v-model="info.volume"
              class="form-control"
              placeholder="Volume in Litre"
            />
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>CNG Type</label>
            <select class="form-control" v-model="info.cng">
              <option value="1">Type A</option>
              <option value="2">Type B</option>
            </select>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>Package</label>
            <select class="form-control" v-model="selectedPackage">
              <option :value="v.id" v-for="(v, i) in packages" :key="i">
                {{ v.name }}
              </option>
            </select>
          </div>
        </div>
        <div v-if="isFuelPackageSelected" class="col-xs-6">
          <div class="form-group">
            <label>Fuel Group</label>
            <select class="form-control" v-model="selectedFuelGroup">
              <option :value="v.tag" v-for="(v, i) in fuel_groups" :key="i">
                {{ v.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>New Service</label>
            <select class="form-control" v-model="info.new_service">
              <option value="0">None</option>
              <option value="1">AC</option>
              <option value="2">Door</option>
            </select>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>Voice Package</label>
            <select class="form-control" v-model="info.voice_service">
              <option value="0">NO</option>
              <option value="1">YES</option>
            </select>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>Engine Control</label>
            <select class="form-control" v-model="info.engine_control">
              <option value="lock">Lock</option>
              <option value="warm">Warm</option>
            </select>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>Monthly Bill</label>
            <input
              type="text"
              v-model="info.bill"
              class="form-control"
              placeholder="ex: 500"
            />
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>Billing Type</label>
            <select class="form-control" v-model="info.billing_type">
              <option value="postpaid">Postpaid</option>
              <option value="prepaid">Prepaid</option>
            </select>
          </div>
        </div>
        <div class="pull-right">
          <button
            class="btn btn-success right-space"
            :class="{ disabled: spinner }"
            @click="save"
          >
            <i class="fa fa-spinner fa-spin" v-if="spinner"></i>
            <i class="fa fa-save" v-if="!spinner"></i> Update
          </button>
          <button class="btn btn-default" @click="cancel">
            <i class="fa fa-times"></i> Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus'
import CarApi from '../../../../api/CarApi'
import FuelApi from '../../../../api/FuelApi'

export default {
  props: ['vehicle'],
  data: () => ({
    spinner: false,
    info: {
      id: '',
      name: '',
      model: '',
      type: '1',
      cng: '1',
      reg_no: '',
      services: [],
      new_service: '1',
      fuel_group: null,
      voice_service: '0',
      engine_control: 'lock',
      bill: '',
      billing_type: 'postpaid',
      volume: 0,
    },
    error: {
      name: '',
      model: '',
      reg_no: '',
    },
    selectedPackage: '0',
    selectedFuelGroup: null,
    packages: [],
    fuel_groups: [],
  }),
  computed: {
    isFuelPackageSelected() {
      return this.selectedPackage == 4 || this.selectedPackage == 5
    },
  },
  mounted() {
    EventBus.$on('car-details-found', this.onCarDetailsFound.bind(this))
    EventBus.$on('car-update-done', this.onCarUpdated.bind(this))
    EventBus.$on('car-validation-failed', this.onValidationFailed.bind(this))
    EventBus.$on('service-packages-found', this.onPackagesFound.bind(this))

    let api = new CarApi(EventBus)
    api.find(this.vehicle.id)
    api.getPackages()

    this.fetchFuelGroups()
  },
  methods: {
    onCarDetailsFound(data) {
      this.info.id = data.id
      this.info.name = data.name
      this.info.model = data.model
      this.info.cng = data.cng
      this.info.reg_no = data.reg_no
      this.info.new_service = data.new_service
      this.info.voice_service = data.voice_service
      this.info.engine_control = data.engine_control
      this.info.fuel_group = data.meta.fuel_group
      this.info.bill = data.bill
      this.info.billing_type = data.billing_type || 'postpaid'
      if (data.type) {
        this.info.type = `${data.type}`
      }
      if (data.meta.volume) {
        this.info.volume = +data.meta.volume
      }
      if (data.package > -1) {
        this.selectedPackage = `${data.package}`
      }
      this.selectedFuelGroup = data.meta.fuel_group
    },

    async fetchFuelGroups() {
      let api = new FuelApi(EventBus)
      this.fuel_groups = [{ id: null, tag: null, name: 'Unspecified' }]
      this.fuel_groups.push(...(await api.fetchGroups()))
    },

    save() {
      this.spinner = true

      this.info.services = _.find(
        this.packages,
        p => p.id == this.selectedPackage
      ).services

      this.info.fuel_group = this.selectedFuelGroup

      let api = new CarApi(EventBus)
      api.update(this.info)
    },

    cancel() {
      EventBus.$emit('show-car-list')
    },

    onCarUpdated(data) {
      if (this.vehicle.id == data.id) {
        this.spinner = false
        toastr.success('Car information updated')
        this.cancel()
      }
    },

    onValidationFailed(error) {
      this.spinner = false
      for (let k in this.error) {
        this.error[k] = ''
      }

      for (let k in error) {
        if (error.hasOwnProperty(k)) {
          if (error[k].length) {
            this.error[k] = error[k][0]
          }
        }
      }
    },

    onPackagesFound(list) {
      this.packages = list
    },
  },
  beforeDestroy() {
    EventBus.$off('car-details-found', this.onCarDetailsFound)
    EventBus.$off('car-update-done', this.onCarUpdated)
    EventBus.$off('car-validation-failed', this.onValidationFailed)
    EventBus.$off('service-packages-found', this.onPackagesFound)
  },
}
</script>
<style lang="scss" scoped></style>
