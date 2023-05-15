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
  props: ['employee'],
  data: () => ({
    data: {
      name: '',
      phone: '',
    },
    errors: {
      name: '',
      phone: '',
    },
  }),
  computed: {

  },
  mounted() {
    EventBus.$on('employee-update-ok', this.onSaved.bind(this));

    this.data = Object.assign({}, this.employee);
  },
  methods: {
    save() {
      this.$store.dispatch('updateEmployee', this.data);
    },
    close() {
      EventBus.$emit('edit-employee-close');
    },
    onSaved() {
      toastr.success('Employee information updated');
      this.close();
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
