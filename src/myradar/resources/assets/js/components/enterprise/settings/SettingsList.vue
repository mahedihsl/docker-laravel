<template>
  <div>
    <h4 class="ash-divider">Customer Settings</h4>
    <div class="col-xs-12">
      <strong class="text-primary">Notification Settings</strong>
      <ul class="list-group">
        <li class="list-group-item">
          Engine On/Off Alert
          <div class="material-switch pull-right">
              <input id="engine" type="checkbox" v-model="noti.engine"/>
              <label for="engine" class="label-success"></label>
          </div>
        </li>
        <li class="list-group-item">
          Geofence Alert
          <div class="material-switch pull-right">
              <input id="geofence" type="checkbox" v-model="noti.fence"/>
              <label for="geofence" class="label-success"></label>
          </div>
        </li>
        <li class="list-group-item">
          Speed Alert
          <div class="material-switch pull-right">
              <input id="speed" type="checkbox" v-model="noti.speed"/>
              <label for="speed" class="label-success"></label>
          </div>
        </li>
        <!-- <li class="list-group-item">
          Date Alert
          <div class="material-switch pull-right">
              <input id="date" type="checkbox" v-model="noti.date"/>
              <label for="date" class="label-success"></label>
          </div>
        </li> -->
      </ul>
      <button class="btn btn-primary pull-right" :class="{disabled: !updateable}" @click="onUpdateClick">
        <i class="fa fa-refresh fa-spin" v-show="loading"></i>Save Changes
      </button>
    </div>

  </div>
</template>
<script>

import EventBus from '../../../util/EventBus';
import SettingsApi from '../../../api/enterprise/SettingsApi.js';
import {mapGetters} from 'vuex';
import store from '../../../enterprise/settings/store';
export default {
  store,
  components: {

  },
  data: () => ({
    old: null,
    noti: {
      engine: 0,
      fence: 0,
      speed: 0,
      date: 0,
      carId: null,
    },
    loading: false,
  }),
  computed: {
    ...mapGetters({
      userId: 'userId',
    }),
    updateable() {
      if (this.old == null) {
        return false;
      }

      for (let key in this.old) {
        if (this.old.hasOwnProperty(key)) {
          if (this.old[key] != this.noti[key]) {
            return true;
          }
        }
      }

      return false;
    }
  },
  mounted() {
    EventBus.$on('settings-list-found', this.onSettingsFound.bind(this));
    EventBus.$on('settings-list-changed', this.onSettingsChanged.bind(this));

    //let api = new SettingsApi(EventBus);

  },
  methods: {
    onSettingsFound(data) {
      this.noti.engine = data.noti_engine;
      this.noti.fence = data.noti_geofence;
      this.noti.speed = data.noti_speed;
      this.noti.date = data.noti_date;
      this.noti.carId = data.car_id;
      this.old = Object.assign({}, this.noti);
    },

    onSettingsChanged() {
      toastr.success('Settings successfully updated');
      //console.log("okkkkk");
      this.loading = false;
      this.old = Object.assign({}, this.noti);
    },

    onUpdateClick() {
      if (this.updateable) {
        this.loading = true;
        this.$store.dispatch('updateSettings',this.getData());
      }
    },

    getData() {
      return {
        user_id: this.userId,
        car_id: this.noti.carId,
        noti_engine: this.noti.engine ? 1 : 0,
        noti_geofence: this.noti.fence ? 1 : 0,
        noti_speed: this.noti.speed ? 1 : 0,
        noti_date: this.noti.date ? 1 : 0,
      }
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
