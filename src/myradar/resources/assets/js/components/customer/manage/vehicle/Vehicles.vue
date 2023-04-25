<template>
    <div>
        <component :is="current" v-bind="props" ref="list"></component>
    </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import CarApi from '../../../../api/CarApi';

import VehicleCreate from './VehicleCreate.vue';
import VehicleEdit from './VehicleEdit.vue';
import VehicleBind from './VehicleBind.vue';
import VehicleList from './VehicleList.vue';
import EventLog from '../event/EventLog.vue';
import Settings from '../preference/Settings.vue';
import FuelView from '../calibration/FuelView.vue';
import GasView from '../calibration/GasView.vue';
import LogTable from '../service/LogTable.vue';
import DevicePhone from '../device/UpdatePhone.vue';
import Share from '../share/Share.vue';

export default {
  props: ['meta', 'customer'],
  components: {
    VehicleCreate,
    VehicleEdit,
    VehicleBind,
    VehicleList,
    EventLog,
    Settings,
    FuelView,
    GasView,
    LogTable,
    DevicePhone,
    Share,
  },
  data: () => ({
    current: null,
    props: {},
  }),
  computed: {
    //
  },
  mounted() {
    EventBus.$on('add-car-click', this.onAddCarClicked.bind(this));
    EventBus.$on('edit-car-click', this.onEditCarClicked.bind(this));
    EventBus.$on('show-car-list', this.onShowCarList.bind(this));
    EventBus.$on('bind-car-device', this.onBindCarDevice.bind(this));
    EventBus.$on('unbind-car-device', this.onUnbindCarDevice.bind(this));
    EventBus.$on('show-fuel-view', this.onFuelCalibrate.bind(this));
    EventBus.$on('show-gas-view', this.onGasCalibrate.bind(this));
    EventBus.$on('show-service-log', this.onServiceLog.bind(this));
    EventBus.$on('show-event-log', this.onEventLog.bind(this));
    EventBus.$on('show-device-phone', this.onDevicePhone.bind(this));
    EventBus.$on('show-car-settings', this.onCarSettings.bind(this));
    EventBus.$on('show-car-settings', this.onCarSettings.bind(this));
    EventBus.$on('show-car-share', this.onCarShare.bind(this));
    EventBus.$on('toggle-car-status', this.onToggleStatus.bind(this));

    this.onShowCarList();
  },
  methods: {
    onAddCarClicked() {
      this.resetProps();
      if (this.meta.create === true) {
        this.current = VehicleCreate;
        this.props.customer = this.customer;
      } else {
        toastr.error('Sorry, you can not create car');
      }
    },

    onEditCarClicked(vehicle) {
      this.resetProps();
      if (this.meta.create === true) {
        this.current = VehicleEdit;
        this.props.vehicle = vehicle;
      } else {
        toastr.error('Sorry, you can not edit car info');
      }
    },

    onShowCarList() {
      this.resetProps();
      this.current = VehicleList;
      this.props.customer = this.customer;
    },

    onBindCarDevice(vehicle) {
      this.renderTechnicalComp(VehicleBind, vehicle);
    },

    onUnbindCarDevice(vehicle) {
      if (this.meta.tech === true) {
        $.confirm({
          title: 'Confirm Unbind ?',
          content: 'The device will be unbinded from car!',
          buttons: {
            confirm: {
              text: 'Yes, Unbind',
              btnClass: 'btn-red',
              action: function () {
                let api = new CarApi(EventBus);
                api.unbindCar(vehicle.id);
              },
            },
            cancel: {
              text: 'Cancel',
            },
          }
        });
      } else {
        toastr.error('Sorry, you do not have access');
      }
    },

    onFuelCalibrate(vehicle) {
      this.renderTechnicalComp(FuelView, vehicle);
    },

    onGasCalibrate(vehicle) {
      this.renderTechnicalComp(GasView, vehicle);
    },

    onServiceLog(vehicle) {
      this.resetProps();
      this.current = LogTable;
      this.props.vehicle = vehicle;
    },

    onEventLog(vehicle) {
      this.resetProps();
      this.current = EventLog;
      this.props.vehicle = vehicle;
    },

    onDevicePhone(vehicle) {
      this.resetProps();
      if (this.meta.admin === true) {
        this.current = DevicePhone;
        this.props.vehicle = vehicle;
      } else {
        toastr.error('Sorry, you do not have access');
      }
    },

    onCarSettings(vehicle) {
      this.resetProps();
      if (this.meta.create === true) {
        this.current = Settings;
        this.props.vehicle = vehicle;
      } else {
        toastr.error('Sorry, you can not edit car info');
      }
    },

    onCarShare(vehicle) {
      this.resetProps();
      if (this.meta.create === true) {
        this.current = Share;
        this.props.vehicle = vehicle;
      } else {
        toastr.error('Sorry, you can not edit car info');
      }
    },

    onToggleStatus(vehicle) {
      if (this.meta.create === true) {
        CarApi.toggleStatus(vehicle.id).then(() => {
          this.$refs.list.refreshList();
        })
      } else {
        toastr.error('Sorry, you can not change car status');
      }
    },

    renderTechnicalComp(comp, vehicle) {
      this.resetProps();
      if (this.meta.tech === true) {
        this.current = comp;
        this.props.vehicle = vehicle;
      } else {
        toastr.error('Sorry, you do not have access');
      }
    },

    resetProps() {
      this.props = {};
    }
  }
}
</script>
<style lang="scss">
</style>
