<template>
  <div class="col-xs-12 col-md-6 col-md-offset-3">
    <h4>Update Information: <strong>{{data.name}}</strong></h4>
    <hr>
    <div class="form">
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" class="form-control" id="name" placeholder="Type name" v-model="data.name">
        <p class="help-block text-danger">{{errors.name}}</p>
      </div>
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" class="form-control" id="phone" placeholder="11 digit phone number" v-model="data.phone">
        <p class="help-block text-danger">{{errors.phone}}</p>
      </div>
      <div class="form-group">
        <label for="car">Select Car</label>
        <select class="form-control" v-model="car">
          <option value="0">Choose Car</option>
          <option :value="c.id" v-for="c in cars">{{c.reg_no}}</option>
        </select>
      </div>
      <button class="btn btn-success" @click="save">
        <i class="fa fa-save"></i> Update
      </button>
      <button class="btn btn-default" @click="close">
        <i class="fa fa-times"></i> Cancel
      </button>
    </div>
  </div>
</template>
<script>
import EventBus from '../../../util/EventBus';
import {mapGetters} from 'vuex';

export default {
  props: ['driver'],
  data: () => ({
    data: null,
    car: '0',
    errors: {
      name: '',
      phone: '',
    },
  }),
  computed: {
    ...mapGetters(['cars']),
  },
  beforeMount() {
    this.data = Object.assign({}, this.driver);
    if (this.driver.car) {
      this.car = this.driver.car.id;
    }
  },
  mounted() {
    EventBus.$on('driver-update-ok', this.onSaved.bind(this));
  },
  methods: {
    save() {
      this.$store.dispatch('updateDriver', {...this.data, car_id: this.car});
    },
    close() {
      EventBus.$emit('edit-driver-close');
    },
    onSaved() {
      this.close();
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
