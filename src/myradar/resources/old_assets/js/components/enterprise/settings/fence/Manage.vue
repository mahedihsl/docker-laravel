<template>
  <div class="col-xs-12 box box-success">
    <h4 class="fenceTool">
      Manage Fences
    </h4>
      <button class="btn btn-primary btn-sm pull-right" @click="addZone">
        <i class="fa fa-plus"></i> New Zone
      </button>

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
    ...mapGetters('fence', ['selectedCarId']),
  },
  mounted() {
    EventBus.$on('zone-form-close', this.onFormClose.bind(this));
    EventBus.$on('fence-deleted', this.onFenceDelete.bind(this));
  },
  methods: {
    ...mapActions('fence', ['list', 'save']),
    addZone() {
      this.current = ZoneForm;
    },
    onFormClose(){
      this.list(this.selectedCarId);
      this.current = ZoneList
    },
    onFenceDelete(){
      this.list(this.selectedCarId);
    }
  }
}
</script>
<style lang="scss" scoped>
.box-success{
  margin-top: 5px;
}

</style>
