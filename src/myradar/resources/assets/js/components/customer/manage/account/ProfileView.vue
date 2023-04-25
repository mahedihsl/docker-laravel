<template>
  <div class="col-xs-12">
    <button class="btn btn-default pull-right" @click="onEditClick">
      <i class="fa fa-pencil"></i> Change Profile
    </button>
    <button class="btn btn-default pull-right" style="margin-right: 15px;" @click="onPhoneClick">
      <i class="fa fa-mobile"></i> Phones
    </button>
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="col-xs-6"></th>
          <th class="col-xs-6"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>Name</strong></td>
          <td>{{customer.name}}</td>
        </tr>
        <tr>
          <td><strong>Phone</strong></td>
          <td>{{customer.phone}}</td>
        </tr>
				<tr>
          <td><strong>Address</strong></td>
          <td>{{customer.address}}</td>
        </tr>
        <tr>
          <td><strong>Email</strong></td>
          <td>{{customer.email}}</td>
        </tr>
        <tr>
          <td><strong>Type</strong></td>
          <td><span :class="type.style">{{ type.name }}</span></td>
        </tr>
        <tr>
          <td><strong>Vehicles</strong></td>
          <td>{{customer.count}}</td>
        </tr>
        <tr>
          <td><strong>Ref No.</strong></td>
          <td>{{customer.ref_no}}</td>
        </tr>
        <tr>
          <td><strong>Status</strong></td>
          <td>
            <span v-if="customer.status" class="text-success">Current Customer</span>
            <span v-else class="text-danger">Old Customer</span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';

export default {
  props: ['customer'],
  data: () => ({

  }),
  computed: {
    type() {
      let styles = ['success', 'primary', 'warning'];
      let names = ['Private', 'Enterprise', 'Public'];
      return {
        'style': 'label label-' + styles[this.customer.type - 1],
        'name':  names[this.customer.type - 1],
      };
    },
  },
  methods: {
    onEditClick() {
      EventBus.$emit('profile-edit-click');
    },
    onPhoneClick() {
      EventBus.$emit('session-list-click')
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
