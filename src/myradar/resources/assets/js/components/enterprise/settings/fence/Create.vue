<template>
  <div class="col-xs-6 col-xs-offset-3">
    <div class="form-group">
      <label>Name</label>
      <input type="text" class="form-control" placeholder="ex: Mirpur" v-model="info.name">
      <p class="text-danger">{{error.name}}</p>
    </div>
    <div class="form-group">
      <label>Lattitude</label>
      <input type="text" class="form-control" placeholder="ex: 23.786623" v-model="info.lat">
      <p class="text-danger">{{error.lat}}</p>
    </div>
    <div class="form-group">
      <label>Longitude</label>
      <input type="text" class="form-control" placeholder="ex: 90.239645" v-model="info.lng">
      <p class="text-danger">{{error.lng}}</p>
    </div>
    <div class="form-group">
      <label>Radius</label>
      <input type="text" class="form-control" placeholder="ex: 500" v-model="info.radius">
      <p class="text-danger">{{error.radius}}</p>
    </div>

    <button type="button" class="btn btn-success btn-sm pull-right" @click="save(info)">
      <i class="fa fa-save" v-if="!loading"></i>
      <i class="fa fa-refresh fa-spin" v-if="loading"></i> Save
    </button>
    <button class="btn btn-default btn-sm right-space pull-right" @click="cancel">
      <i class="fa fa-times"></i> Cancel
    </button>
  </div>
</template>
<script>
import {mapGetters, mapMutations, mapActions} from 'vuex';

import EventBus from '../../../../util/EventBus';

export default {
  data: () => ({
    info: {
      name: '',
      lat: '',
      lng: '',
      radius: '',
    },
    loading: false,
  }),
  computed: {
    ...mapGetters('fence', ['error', 'selectedCarId']),

  },
  mounted() {
    EventBus.$on('zone-save-start', () => this.loading = true);
    EventBus.$on('zone-save-fail', () => this.loading = false);
  },
  methods: {
    ...mapActions('fence', ['save']),
    ...mapMutations('fence', {setError: 'error'}),
    cancel() {
      this.setError(null);
      EventBus.$emit('zone-form-close');
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
