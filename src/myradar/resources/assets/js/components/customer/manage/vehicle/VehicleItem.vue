<template>
  <tr class="car-item" :class="{focused}">
    <td>
      <span class="right-space">{{vehicle.reg_no}}</span>
      <span class="label label-success" v-if="!!state && state.shared">Shared</span>
    </td>
    <td>
      <i class="fa fa-spinner fa-spin" v-if="!state"></i>
      <span v-if="!!state">{{state.label}}</span>
    </td>
    <td>
      <i class="fa fa-spinner fa-spin" v-if="!state"></i>
      <span v-if="!!state">{{state.phone}}</span>
    </td>
    <td>
      <span class="right-space" :class="{'text-success': vehicle.status, 'text-danger': !vehicle.status}">
        <strong>{{vehicle.status ? 'Enabled' : 'Disabled'}}</strong>
      </span>
    </td>
    <td>
      <i class="fa fa-spinner fa-spin" v-if="!state"></i>
      <span v-if="!!state">{{state.pulse}}</span>
    </td>
    <td>
      <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Action <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li>
            <a href="#" @click="onUnbindClick" v-if="!detached">
              <i class="fa fa-plug"></i> Unbind Device
            </a>
          </li>
          <li>
            <a href="#" @click="onPhoneClick" v-if="!detached">
              <i class="fa fa-microchip"></i> Change Phone No.
            </a>
          </li>
          <li>
            <a href="#" @click="onFuelCalibrateClick" v-if="!detached">
              <i class="fa fa-tint"></i> Fuel Calibration
            </a>
          </li>
          <li>
            <a href="#" @click="onGasCalibrateClick" v-if="!detached">
              <i class="fa fa-circle-o"></i> Gas Calibration
            </a>
          </li>
          <li>
            <a href="#" @click="onServiceLogClick" v-if="!detached">
              <i class="fa fa-bug"></i> Service Diagnosis
            </a>
          </li>
          <li>
            <a href="#" @click="onEventLogClick" v-if="!detached">
              <i class="fa fa-bullhorn"></i> Event Log
            </a>
          </li>
          <li>
            <a href="#" @click="onEditCarClick">
              <i class="fa fa-pencil"></i> Update Info
            </a>
          </li>
          <li>
            <a href="#" @click="onPreferenceClick" v-if="!detached">
              <i class="fa fa-cog"></i> Preference
            </a>
          </li>
          <li>
            <a href="#" @click="onShareClick" v-if="!detached">
              <i class="fa fa-share"></i> Share
            </a>
          </li>
          <li v-if="!!state && !state.shared">
            <a href="#" @click="onToggleClick" v-if="!detached">
              <i class="fa fa-toggle-on"></i> Toggle Status
            </a>
          </li>
          <li>
            <a href="#" @click="onBindClick" v-if="detached">
              <i class="fa fa-plug"></i> Bind New Device
            </a>
          </li>
        </ul>
      </div>
    </td>
  </tr>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import CarApi from '../../../../api/CarApi';

export default {
  props: ['vehicle', 'focused', 'userId'],
  data: () => ({
    state: null,
  }),
  computed: {
    detached() {
      return !!this.state && !this.state.value;
    }
  },
  mounted() {
    EventBus.$on('car-state-found', this.onStateFound.bind(this));
    EventBus.$on('car-unbind-done', this.onUnbindSuccess.bind(this));
    EventBus.$on('car-unbind-failed', this.onUnbindFailed.bind(this));

    $('.dropdown-toggle').dropdown();

    this.getCarState();
  },
  methods: {
    getCarState() {
      let api = new CarApi(EventBus);
      api.getCarState(this.vehicle.id, this.userId);
    },

    onStateFound(state) {
      if (state.car_id == this.vehicle.id) {
          this.state = state;
          this.vehicle.state = state;
      }
    },

    onBindClick() {
      EventBus.$emit('bind-car-device', this.vehicle);
    },

    onUnbindClick() {
      EventBus.$emit('unbind-car-device', this.vehicle);
    },

    onUnbindSuccess(carId) {
      if (this.vehicle.id == carId) {
        toastr.success('Device successfully unbinded from car');
        this.getCarState();
      }
    },

    onUnbindFailed(message) {
      $.alert({
          title: 'Error !',
          content: message,
          type: 'red',
          theme: 'material',
      });
    },

    onFuelCalibrateClick() {
      EventBus.$emit('show-fuel-view', this.vehicle);
    },

    onGasCalibrateClick() {
      EventBus.$emit('show-gas-view', this.vehicle);
    },

    onServiceLogClick() {
      EventBus.$emit('show-service-log', this.vehicle);
    },

    onEventLogClick() {
      EventBus.$emit('show-event-log', this.vehicle);
    },

    onPhoneClick() {
      EventBus.$emit('show-device-phone', this.vehicle);
    },

    onEditCarClick() {
      EventBus.$emit('edit-car-click', this.vehicle);
    },

    onPreferenceClick() {
      EventBus.$emit('show-car-settings', this.vehicle);
    },

    onShareClick() {
      EventBus.$emit('show-car-share', this.vehicle);
    },

    onToggleClick() {
      EventBus.$emit('toggle-car-status', this.vehicle);
    }
  }
}
</script>
<style lang="scss" scoped>
.car-item {
    cursor: pointer;
}
</style>
