<template>
  <div class="col-xs-12">
    <h4>
      Manage Zones
      <button class="btn btn-primary btn-sm pull-right" @click="addZone">
        <i class="fa fa-plus"></i> New Zone
      </button>
    </h4>
    <hr class="divider">

    <component :is="current"></component>
  </div>
</template>
<script>
import {mapGetters, mapActions} from 'vuex';

import EventBus from '../../../../util/EventBus';

import ZoneList from './List.vue';
import ZoneForm from './Create.vue';

export default {
  components: {
    ZoneList, ZoneForm,
  },
  data: () => ({
    current: ZoneList,
  }),
  computed: {
    ...mapGetters('zone', {

    }),
  },
  mounted() {
    EventBus.$on('zone-form-close', () => this.current = ZoneList);

    this.list();
  },
  methods: {
    ...mapActions('zone', ['list', 'save']),
    addZone() {
      this.current = ZoneForm;
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
