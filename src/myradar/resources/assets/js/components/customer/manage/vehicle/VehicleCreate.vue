<template>
  <div class="row">
    <div class="row header">
      <div class="col-md-12">
        <h4 class="text-center text-primary">Add New Car</h4>
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
            <label>Activation Key <span class="text-maroon">*</span></label>
            <input
              type="text"
              v-model="info.activation_key"
              class="form-control"
              placeholder="4 digit code"
            />
            <span class="helper-text text-danger">{{
              error.activation_key
            }}</span>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>Promo Key</label>
            <input
              type="text"
              v-model="info.promo_key"
              class="form-control"
              placeholder="6 digit code"
            />
            <span class="helper-text text-danger">{{ error.promo_key }}</span>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label>Vehicle Type</label>
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
              <option
                v-bind:value="i"
                v-for="(v, i) in packages"
                v-bind:key="i"
                >{{ v.name }}</option
              >
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
            <i class="fa fa-save" v-if="!spinner"></i> Save
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
  props: ['customer'],
  data: () => ({
    spinner: false,
    info: {
      name: '',
      model: '',
      type: '1',
      cng: '1',
      reg_no: '',
      user_id: '',
      services: [],
      promo_key: '',
      activation_key: '',
      new_service: '1',
      fuel_group: null,
      voice_service: '0',
      billing_type: 'postpaid',
      volume: 0, // application for 'generator' type
    },
    error: {
      name: '',
      model: '',
      reg_no: '',
      promo_key: '',
      activation_key: '',
    },
    selectedPackage: '0',
    selectedFuelGroup: null,
    packages: [],
  }),
  computed: {
    isFuelPackageSelected() {
      return this.selectedPackage == 4 || this.selectedPackage == 5
    },
  },
  mounted() {
    EventBus.$on('car-save-done', this.onCarSaved.bind(this))
    EventBus.$on('car-validation-failed', this.onValidationFailed.bind(this))
    EventBus.$on('service-packages-found', this.onPackagesFound.bind(this))
    EventBus.$on('promo-invalid', this.onInvalidPromo.bind(this))
    this.info.user_id = this.customer.id

    let api = new CarApi(EventBus)
    api.getPackages()

    this.fetchFuelGroups()
  },
  methods: {
    save() {
      this.spinner = true

      this.info.services = this.packages[
        parseInt(this.selectedPackage)
      ].services

      this.info.fuel_group = this.selectedFuelGroup

      let api = new CarApi(EventBus)
      api.save(this.info)
    },

    async fetchFuelGroups() {
      let api = new FuelApi(EventBus)
      this.fuel_groups = [{ id: null, tag: null, name: 'Unspecified' }]
      this.fuel_groups.push(...(await api.fetchGroups()))
    },

    cancel() {
      EventBus.$emit('show-car-list')
    },

    onCarSaved() {
      this.spinner = false
      toastr.success('Car information saved')
      this.cancel()
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

    onInvalidPromo(data) {
      toastr.error(data.message)
      this.spinner = false
    },
  },
}
</script>
<style lang="scss" scoped></style>
