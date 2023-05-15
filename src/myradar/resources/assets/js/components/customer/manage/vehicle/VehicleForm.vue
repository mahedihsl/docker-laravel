<template>
  <div class="row">
    <div class="row header">
      <div class="col-md-12">
        <h4 class="text-center text-primary">Add New Car</h4>
        <hr>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-6 col-md-offset-3">
        <div class="form">
          <div class="form-group">
            <label>Name</label>
            <input type="text" v-model="info.name" class="form-control" placeholder="ex: Toyota">
            <span class="helper-text text-danger">{{error.name}}</span>
          </div>
          <div class="form-group">
            <label>Model</label>
            <input type="text" v-model="info.model" class="form-control" placeholder="ex: 2012">
            <span class="helper-text text-danger">{{error.model}}</span>
          </div>
          <div class="form-group">
            <label>Reg No. <span class="text-maroon">*</span></label>
            <input type="text" v-model="info.reg_no" class="form-control" placeholder="ex: Dhaka-Ka xx-xxxx">
            <span class="helper-text text-danger">{{error.reg_no}}</span>
          </div>
          <div class="form-group">
            <label>Activation Key <span class="text-maroon">*</span></label>
            <input type="text" v-model="info.activation_key" class="form-control" placeholder="4 digit code">
            <span class="helper-text text-danger">{{error.activation_key}}</span>
          </div>
          <div class="form-group">
            <label>Promo Key</label>
            <input type="text" v-model="info.promo_key" class="form-control" placeholder="6 digit code">
            <span class="helper-text text-danger">{{error.promo_key}}</span>
          </div>
          <div class="form-group">
            <label>Type</label>
            <select class="form-control" v-model="info.type">
              <option value="1">Car</option>
              <option value="2">Van</option>
              <option value="3">Bike</option>
            </select>
          </div>
          <div class="form-group">
            <label>Package</label>
            <select class="form-control" v-model="package">
              <option v-bind:value="i" v-for="(v, i) in packages">{{v.name}}</option>
            </select>
          </div>
          <div class="pull-right" style="margin-bottom: 20px;">
            <button class="btn btn-success" :class="{disabled: spinner}" @click="save">
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
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import CarApi from '../../../../api/CarApi';

export default {
  props: ['customer'],
  data: () => ({
    spinner: false,
    info: {
      name: '',
      type: '1',
      model: '',
      reg_no: '',
      user_id: '',
      services: [],
      promo_key: '',
      activation_key: '',
    },
    error: {
      reg_no: '',
      promo_key: '',
      activation_key: '',
    },
    package: '0',
    packages: [],
  }),
  mounted() {
    EventBus.$on('car-save-done', this.onCarSaved.bind(this));
    EventBus.$on('car-validation-failed', this.onValidationFailed.bind(this));
    EventBus.$on('service-packages-found', this.onPackagesFound.bind(this));

    this.info.user_id = this.customer.id;

    let api = new CarApi(EventBus);
    api.getPackages();
  },
  methods: {
    save() {
      this.spinner = true;

      this.info.services = this.packages[parseInt(this.package)].services;

      let api = new CarApi(EventBus);
      api.save(this.info);
    },

    cancel() {
      EventBus.$emit('show-car-list');
    },

    onCarSaved() {
      this.spinner = false;
      this.cancel();
    },

    onValidationFailed(error) {
      this.spinner = false;
      for (let k in this.error) {
        this.error[k] = '';
      }

      for (let k in error) {
        if (error.hasOwnProperty(k)) {
          if (error[k].length) {
            this.error[k] = error[k][0];
          }
        }
      }
    },

    onPackagesFound(list) {
      this.packages = list;
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
