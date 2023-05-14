<template>
  <div class="tw-w-full tw-flex tw-flex-row gap-x-2">
    <div class="tw-w-2/12 tw-mx-2">
      <select class="form-control" v-model="info.pin_name">
        <option value="dm1">DM1</option>
        <option value="dm2">DM2</option>
        <option value="dm3">DM3</option>
        <option value="dm4">DM4</option>
        <option value="dm5">DM5</option>
        <option value="dm6">DM6</option>
        <option value="dm7">DM7</option>
        <option value="dm8">DM8</option>
        <option value="am1">AM1</option>
        <option value="am2">AM2</option>
        <option value="am3">AM3</option>
        <option value="am4">AM4</option>
        <option value="am5">AM5</option>
        <option value="am6">AM6</option>
      </select>
    </div>
    <div class="tw-w-3/12 tw-mx-2">
      <select class="form-control" v-model="info.type">
        <option value="main_phase">MAIN PHASE</option>
        <option value="dg_status">DG STATUS</option>
        <option value="dg_fuel">DG FUEL</option>
        <option value="temperature">TEMPERATURE</option>
        <option value="door_status">DOOR STATUS</option>
        <option value="battery_cell">BATTERY CELL</option>
        <option value="battery_terminal">BATTERY TERMINAL</option>
        <option value="battery_offset">BATTERY OFFSET</option>
        <option value="smoke_detector">SMOKE DETECTOR</option>
      </select>
    </div>
    <div class="tw-w-1/12 tw-mx-2">
      <input
        type="text"
        v-model="info.factor"
        class="form-control"
        placeholder="Factor"
      />
    </div>
    <div class="tw-w-1/12 tw-mx-2">
      <input
        type="text"
        v-model="info.offset"
        class="form-control"
        placeholder="Offset"
      />
    </div>
    <div class="tw-w-3/12 tw-mx-2">
      <input
        type="text"
        v-model="info.label"
        class="form-control"
        placeholder="Optional Name"
      />
    </div>
    <div
      class="
        tw-w-2/12
        tw-mx-2
        tw-flex
        tw-flex-row
        tw-justify-center
        tw-items-center
        tw-gap-x-2
      "
    >
      <button class="btn btn-success btn-sm" @click="save">
        <i class="fa fa-check"></i>
        Save
      </button>
      <button class="btn btn-default btn-sm" @click="$emit('close', comId, false)">
        <i class="fa fa-times"></i>
        Cancel
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    siteId: {
      type: String,
      required: true,
    },
    comId: {
      type: Number,
      required: true,
    },
  },
  data: () => ({
    info: {
      pin_name: 'am1',
      type: 'main_phase',
      factor: 1.0,
      offset: 0.0,
      label: '',
    },
  }),
  mounted() {},
  methods: {
    async save() {
      try {
        const data = {
          ...this.info,
          site_id: this.siteId,
          com_id: +this.comId,
        }
        await this.$store.dispatch('savePinConfig', data)
        this.$emit('close', this.comId, true)
      } catch (error) {
        console.log('error saving config', error)
      }
    },
  },
}
</script>

<style lang="scss" scoped>
</style>