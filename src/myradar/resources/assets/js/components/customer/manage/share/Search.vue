<template>
  <div>
    <strong>Search Customer</strong>
    <div class="row">
      <div class="col-xs-4 no-padding-col">
        <input type="text" class="form-control" placeholder="Type Name" v-model="params.name">
      </div>
      <div class="col-xs-4 no-padding-col">
        <input type="text" class="form-control" placeholder="Phone Number" v-model="params.phone">
      </div>
      <div class="col-xs-4">
        <button class="btn btn-primary btn-sm" v-on:click="search"><i class="fa fa-search"></i> Search</button>
      </div>
    </div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="col-xs-2">#</th>
          <th class="col-xs-6">Name</th>
          <th class="col-xs-4">Action</th>
        </tr>
      </thead>
      <tbody>
        <user v-for="(u, i) in result" :user="u" :serial="i + 1" :key="i" :shared="false"></user>
      </tbody>
    </table>
  </div>
</template>
<script>
import User from './User.vue';
import {mapGetters, mapActions} from 'vuex';

export default {
  components: {
    User,
  },
  data: () => ({
    params: {
      name: '',
      phone: '',
    }
  }),
  computed: {
    ...mapGetters('share', ['result']),
  },
  methods: {
    ...mapActions('share', ['searchUser']),
    search() {
      this.searchUser(this.params);
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
