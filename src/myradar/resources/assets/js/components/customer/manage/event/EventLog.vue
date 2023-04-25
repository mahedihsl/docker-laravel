<template>
  <div class="row">
    <div class="row header">
      <div class="col-md-10 col-md-offset-1">
        <h4 class="text-center text-primary">
          Event log of Car: {{vehicle.reg_no}}
          <button class="btn btn-default pull-right" @click="close">
            <i class="fa fa-arrow-left"></i> Back
          </button>
        </h4>
        <hr>
      </div>
      <div class="col-md-8 col-md-offset-2">
        <no-data v-if="nothing && !loading"></no-data>
        <spinner v-show="loading"></spinner>
        <pager v-on:click.native="onPageChanged(pagination.current_page)"
                :pagination="pagination"
                :offset="offset"
                v-show="!(nothing || loading)">
        </pager>
        <br>
        <event v-for="(e, i) in events" :event="e" :serial="i + 1" :key="i" v-if="!loading"></event>
        <br>
        <pager v-on:click.native="onPageChanged(pagination.current_page)"
                :pagination="pagination"
                :offset="offset"
                v-show="!(nothing || loading)">
        </pager>
      </div>
    </div>
  </div>
</template>
<script>
import {mapGetters, mapActions} from 'vuex';
import EventBus from '../../../../util/EventBus';

import Event from './Event.vue';
import NoData from '../../../util/NoItemFound.vue';
import Spinner from '../../../util/Spinner.vue';
import Pager from '../../../util/Pagination.vue';

export default {
  props: ['vehicle'],
  components: {
    Event, NoData, Spinner, Pager,
  },
  data: () => ({
    offset: 4,
  }),
  computed: {
    ...mapGetters('event', ['events', 'pagination', 'loading', 'nothing']),
  },
  mounted() {
    this.onPageChanged(1);
  },
  methods: {
    ...mapActions('event', ['getEvents']),
    onPageChanged(page) {
      this.getEvents({carId: this.vehicle.id, page});
    },
    close() {
      EventBus.$emit('show-car-list');
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
