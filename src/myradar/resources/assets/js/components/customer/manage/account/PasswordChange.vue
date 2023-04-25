<template>
  <div class="col-xs-12">
    <div class="form vertical-space-medium">
      <div class="form-group">
        <label>New Password</label>
        <input type="text" class="form-control" v-model="pass1">
        <p class="text-danger">{{error.password}}</p>
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="text" class="form-control" v-model="pass2">
        <p class="text-danger">{{error.match}}</p>
      </div>
      <button class="btn btn-success" @click="update">
        <i class="fa fa-save" v-if="!loading"></i>
        <i class="fa fa-refresh fa-spin" v-if="loading"></i>
        Change
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
    pass1: '',
    pass2: '',
    error: {},
    loading: false,
  }),
  mounted() {
    EventBus.$on('password-update-done', this.onSuccess.bind(this));
    EventBus.$on('password-update-error', this.onError.bind(this));
  },
  methods: {
    update() {
      this.loading = true;

      let api = new CustomerApi(EventBus);
      api.password(this.customer.id, this.pass1, this.pass2);
    },

    onSuccess(profile) {
      this.loading = false;
      toastr.success('Password Changed');
      EventBus.$emit('profile-edit-done', null);
    },

    onError(status, error) {
      this.loading = false;
      if (status == 422) {
        this.error = error;
      } else {
        toastr.error(error);
      }
    },

    cancel(status, error) {
      EventBus.$emit('profile-edit-done', null);
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
