<template>
  <div class="col-xs-12 col-md-6 col-md-offset-3">
    <h4>Add New Employee</h4>
    <hr>
    <div class="form">
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" class="form-control" id="name" placeholder="Type name" v-model="data.name">
        <p class="text-danger">{{errors.name}}</p>
      </div>
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" class="form-control" id="phone" placeholder="11 digit phone number" v-model="data.phone">
        <p class="text-danger">{{errors.phone}}</p>
      </div>
      <button class="btn btn-success" @click="save">
        <i class="fa fa-save" v-show="!loading"></i>
        <i class="fa fa-refresh fa-spin" v-show="loading"></i> Save
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
    ...mapGetters(['loading']),
  },
  mounted() {
    EventBus.$on('employee-save-ok', this.onSuccess.bind(this));
    EventBus.$on('employee-save-fail', this.onFailed.bind(this));
  },
  methods: {
    save() {
      this.$store.dispatch('saveEmployee', this.data)
    },
    close() {
      EventBus.$emit('add-employee-close');
    },
    onSuccess() {
      toastr.success('Employee created successfully');
      this.close();
    },
    onFailed(error) {
      for (let k in this.errors) {
        this.errors[k] = '';
      }

      for (let k in error) {
        if (error.hasOwnProperty(k)) {
          if (error[k].length) {
            this.errors[k] = error[k];
          }
        }
      }
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
