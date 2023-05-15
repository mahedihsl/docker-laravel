<template>
  <div>
    <no-item v-if="!count"></no-item>
    <table class="table table-striped" v-if="count">
      <thead>
        <tr>
          <th class="col-xs-1">#</th>
          <th class="col-xs-2">Name</th>
          <th class="col-xs-2">Lat.</th>
          <th class="col-xs-2">Lng.</th>
          <th class="col-xs-2">Radius (meter)</th>
          <th class="col-xs-2">Action</th>
        </tr>
      </thead>
      <tbody>
        <zone v-for="(z, i) in zones" :zone="z" :serial="i + 1" :key="i"></zone>
      </tbody>
    </table>
  </div>
</template>
<script>
import {mapGetters, mapActions} from 'vuex';

import Zone from './Item.vue';
import NoItem from '../../../util/NoItemFound.vue';

export default {
  components: {
    Zone, NoItem,
  },
  data: () => ({

  }),
  computed: {
    ...mapGetters('fence', ['zones', 'count']),
  },
  mounted() {
    
  },
  methods: {
    ...mapActions('fence', ['list']),
  }
}
</script>
<style lang="scss" scoped>
</style>
