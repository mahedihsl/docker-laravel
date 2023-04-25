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
        <li class="list-group-item">
          Date Alert
          <div class="material-switch pull-right">
              <input id="date" type="checkbox" v-model="noti.date"/>
              <label for="date" class="label-success"></label>
          </div>
        </li>
        <li class="list-group-item">
          SMS Pack #1
          <div class="material-switch pull-right">
              <input id="pack1" type="checkbox" v-model="noti.pack1"/>
              <label for="pack1" class="label-success"></label>
          </div>
        </li>
        <li class="list-group-item">
          SMS Pack #2
          <div class="material-switch pull-right">
              <input id="pack2" type="checkbox" v-model="noti.pack2"/>
              <label for="pack2" class="label-success"></label>
          </div>
        </li>
      </ul>
      <button class="btn btn-primary pull-right" :class="{disabled: !updateable}" @click="onUpdateClick">
        <i class="fa fa-refresh fa-spin" v-show="loading"></i>Save Changes
      </button>
    </div>

    <div class="col-xs-12 v-margin">
      <zone-manage></zone-manage>
    </div>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import CustomerApi from '../../../../api/CustomerApi';

import ZoneManage from '../zone/Manage.vue';

export default {
  props: ['customer'],
  components: {
    ZoneManage,
  },
  data: () => ({
    old: null,
    noti: {
      engine: 0,
      fence: 0,
      speed: 0,
      date: 0,
      pack1: 0,
      pack2: 0,
    },
    loading: false,
  }),
  computed: {
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
    EventBus.$on('customer-settings-found', this.onSettingsFound.bind(this));
    EventBus.$on('customer-settings-changed', this.onSettingsChanged.bind(this));

    let api = new CustomerApi(EventBus);
    api.getSettings(this.customer.id);
  },
  methods: {
    onSettingsFound(data) {
      this.noti.engine = data.noti_engine;
      this.noti.fence = data.noti_geofence;
      this.noti.speed = data.noti_speed;
      this.noti.date = data.noti_date;

      this.noti.pack1 = data.sms_pack1 == undefined ? 0 : data.sms_pack1;
      this.noti.pack2 = data.sms_pack2 == undefined ? 0 : data.sms_pack2;

      this.old = Object.assign({}, this.noti);
    },

    onSettingsChanged() {
      toastr.success('Settings successfully updated');
      this.loading = false;
      this.old = Object.assign({}, this.noti);
    },

    onUpdateClick() {
      if (this.updateable) {
        this.loading = true;
        let api = new CustomerApi(EventBus);
        api.updateSettings(this.getData());
      }
    },

    getData() {
      return {
        user_id: this.customer.id,
        noti_engine: this.noti.engine ? 1 : 0,
        noti_geofence: this.noti.fence ? 1 : 0,
        noti_speed: this.noti.speed ? 1 : 0,
        noti_date: this.noti.date ? 1 : 0,
        sms_pack1: this.noti.pack1 ? 1 : 0,
        sms_pack2: this.noti.pack2 ? 1 : 0,
      }
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
