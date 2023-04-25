<template>
  <div class="row">
    <div class="col-xs-12">
      <h4>Share Car Access of: {{vehicle.reg_no}}</h4>
      <hr>
    </div>
    <div class="col-xs-12 col-md-6">
      <search></search>
    </div>
    <div class="col-xs-12 col-md-6">
      <shared-list></shared-list>
    </div>
  </div>
</template>
<script>
import {mapMutations} from 'vuex';

import Search from './Search.vue';
import SharedList from './SharedList.vue';

export default {
  props: ['vehicle'],
  components: {
    Search, SharedList,
  },
  data: () => ({

  }),
  mounted() {
    this.setCar(this.vehicle);
  },
  methods: {
    ...mapMutations('share', ['setCar']),
  }
}
</script>
<style lang="scss" scoped>
</style>
