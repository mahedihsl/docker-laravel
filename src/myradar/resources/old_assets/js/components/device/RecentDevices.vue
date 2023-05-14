<template>
    <div class="col-md-12">
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th class="col-sm-1">Commercial ID</th>
                    <th class="col-sm-2">Phone Number</th>
                    <th class="col-sm-2">IMEI</th>
                    <th class="col-sm-1">Version</th>
                    <th class="col-sm-3">Created At</th>
                    <th class="col-sm-2">New Version</th>
                    <th class="col-sm-1">Action</th>
                </tr>
            </thead>
            <tbody>
                <device v-for="(d, i) in items" :device="d" :key="i"></device>
            </tbody>
        </table>
        <button class="btn btn-default" @click="load(-1)">
          First Page
        </button>
        <button class="btn btn-default" @click="load(1)">
          <i class="fa fa-arrow-right"></i> Next
        </button>
    </div>
</template>
<script>
import EventBus from '../../util/EventBus';
import Api from '../../api/DeviceApi';

import Device from './Device.vue';

export default {
    components: { Device },
    data: () => ({
        items: [],
        skip: 0,
        direction: 1,
    }),
    mounted() {
      EventBus.$on('device-list-found', this.onListFound.bind(this));
      EventBus.$on('device-item-found', this.onItemFound.bind(this));

      let api = new Api(EventBus);
      api.getRecentDevices(this.skip);
    },
    methods: {
      onListFound(list) {
        this.items = list;
        this.skip += list.length;
      },
      onItemFound(item) {
        this.items.unshift(item);
        this.items.pop();
      },
      load(dir) {
        this.direction = dir;
        let api = new Api(EventBus);
        this.skip = this.direction == -1 ? 0 : this.skip;
        api.getRecentDevices(this.skip);
      },

    }
}
</script>
<style lang="scss" scoped>

</style>
