<template>
  <div class="tw-w-full">
    <div class="tw-w-full tw-flex tw-flex-row tw-items-center tw-gap-x-4">
      <button
        class="btn btn-sm btn-default tw-flex-shrink-0"
        @click="$emit('close', 'configure')"
      >
        <i class="fa fa-arrow-left"></i>
      </button>
      <h4 class="tw-flex-grow">{{ site.name }} Configuration</h4>
      <button
        class="btn btn-sm btn-primary tw-flex-shrink-0"
        @click="showBindForm = true"
      >
        <i class="fa fa-plug"></i>
        Bind Device
      </button>
    </div>
    <div class="tw-w-full tw-flex tw-flex-col tw-gap-y-5 tw-mt-5">
      <DeviceBindForm
        v-if="showBindForm"
        :site="site"
        @binded="onBindCompleted"
        @close="showBindForm = false"
      />
      <div
        class="tw-w-full tw-border-b tw-border-gray-300"
        v-for="(dev, i) in site.com_ids"
        :key="i"
      >
        <div class="tw-w-full tw-flex tw-flex-row tw-items-center">
          <h4 class="tw-flex-grow">Device Com. ID: {{ dev }}</h4>
          <button class="btn btn-sm btn-warning" @click="unbind(dev)">
            Unbind device
          </button>
        </div>
        <div class="tw-w-full tw-flex tw-flex-col tw-gap-y-3">
          <pin-header></pin-header>
          <pin-config
            v-for="conf in pinConfigsOfDevice(dev)"
            :key="conf.id"
            :config="conf"
          >
          </pin-config>
          <div
            v-if="!pinConfigFormVisibility(+dev)"
            class="tw-w-full tw-flex tw-flex-row tw-justify-end tw-my-4"
          >
            <div class="tw-w-2/12 tw-flex tw-flex-row tw-justify-center">
              <button
                class="btn btn-primary btn-sm"
                @click="showPinConfigForm(+dev)"
              >
                <i class="fa fa-plus"></i>
                Add Pin
              </button>
            </div>
          </div>
          <pin-config-form
            v-if="pinConfigFormVisibility(+dev)"
            :site-id="site.id"
            :com-id="dev"
            @close="onPinConfigFormClosed"
          >
          </pin-config-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PinHeader from './PinHeader.vue'
import PinConfig from './PinConfig.vue'
import PinConfigForm from './PinConfigForm.vue'
import DeviceBindForm from './DeviceBindForm.vue'

import { mapGetters } from 'vuex'

export default {
  props: {},
  components: {
    PinHeader,
    PinConfig,
    PinConfigForm,
    DeviceBindForm,
  },
  data: () => ({
    showBindForm: false,
    visibleForms: [],
  }),
  computed: {
    ...mapGetters('rms', ['site', 'pinConfigsOfDevice']),
  },
  mounted() {},
  methods: {
    async unbind(com_id) {
      try {
        if (confirm('Are you sure you want unbind this device ?')) {
          await this.$store.dispatch('rms/unbindDevice', { site_id: this.site.id, com_id })
        }
      } catch (error) {
        console.log('unbind error', error)
      }
    },
    async onPinConfigFormClosed(comId, isSavingSuccessful) {
      if (isSavingSuccessful) {
        await this.$store.dispatch('rms/fetchPinConfigs', {
          site_id: this.site.id,
        })
      }
      const index = this.visibleForms.findIndex(id => id === comId)
      if (index !== -1) {
        this.visibleForms.splice(index, 1)
      }
    },
    showPinConfigForm(comId) {
      if (!this.visibleForms.includes(comId)) {
        this.visibleForms.push(comId)
      }
    },
    pinConfigFormVisibility(comId) {
      return this.visibleForms.includes(comId)
    },
    onBindCompleted(comId) {
      this.showBindForm = false
    },
  },
}
</script>

<style lang="scss" scoped>
</style>