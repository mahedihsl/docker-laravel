<template>
  <div class="col-xs-12">
    <div class="form vertical-space-medium">
      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" v-model="info.name">
        <p class="text-danger">{{error.name}}</p>
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input type="text" class="form-control" v-model="info.phone">
        <p class="text-danger">{{error.phone}}</p>
      </div>
			<div class="form-group">
        <label>Address</label>
        <input type="text" class="form-control" v-model="info.address">
        <p class="text-danger">{{error.address}}</p>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" v-model="info.email">
        <p class="text-danger">{{error.email}}</p>
      </div>
      <div class="form-group">
        <label>Type</label>
        <select class="form-control" v-model="info.type">
          <option value="1">Private</option>
          <option value="2">Enterprise</option>
        </select>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select class="form-control" v-model="info.status">
          <option value="1">Current Customer</option>
          <option value="0">Old Customer</option>
        </select>
      </div>
      <div class="form-group">
        <label>Ref No.</label>
        <input type="text" class="form-control" v-model="info.ref_no">
      </div>
      <button class="btn btn-success" @click="update">
        <i class="fa fa-save" v-if="!loading"></i>
        <i class="fa fa-refresh fa-spin" v-if="loading"></i>
        Save Changes
      </button>
      <button class="btn btn-default" @click="cancel">
        <i class="fa fa-times"></i> Cancel
      </button>
    </div>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import CustomerApi from '../../../../api/CustomerApi';

export default {
  props: ['customer'],
  data: () => ({
    info: {},
    error: {},
    loading: false,
  }),
  mounted() {
    EventBus.$on('profile-update-done', this.onSuccess.bind(this));
    EventBus.$on('profile-update-error', this.onError.bind(this));

    this.info = Object.assign({}, this.customer);
  },
  methods: {
    update() {
      this.loading = true;

      let api = new CustomerApi(EventBus);
      api.update(this.info);
    },

    onSuccess(profile) {
      this.loading = false;
      toastr.success('Profile Updated');
      EventBus.$emit('profile-edit-done', profile);
    },

    onError(status, error) {
      this.loading = false;
      if (status == 422) {
        this.error = error;
      } else {
        toastr.error(error);
      }
    },

    cancel() {
      EventBus.$emit('profile-edit-done', null);
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
