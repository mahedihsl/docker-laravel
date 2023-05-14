<template>
  <div>
    <strong>Shared With</strong>
    <spinner v-if="loading.shared" :extra-height="false" :floating="false"></spinner>
    <table class="table table-striped" v-if="!loading.shared">
      <thead>
        <tr>
          <th class="col-xs-2">#</th>
          <th class="col-xs-6">Name</th>
          <th class="col-xs-4">Action</th>
        </tr>
      </thead>
      <tbody>
        <user v-for="(u, i) in users" :user="u" :serial="i +  1" :key="i" :shared="true"></user>
      </tbody>
    </table>
  </div>
</template>
<script>
import {mapGetters, mapActions, mapMutations} from 'vuex';

import User from './User.vue';
import Spinner from '../../../util/Spinner.vue';

export default {
  components: {
    User, Spinner,
  },
  data: () => ({

  }),
  computed: {
    ...mapGetters('share', ['users', 'loading']),
  },
  mounted() {
    this.sharedLoading(true);
    setTimeout(this.getSharedUsers.bind(this), 500);
  },
  methods: {
    ...mapMutations('share', ['sharedLoading']),
    ...mapActions('share', ['getSharedUsers']),
  }
}
</script>
<style lang="scss" scoped>
</style>
