<template>
  <div
    class="
      tw-w-full
      tw-flex
      tw-flex-col
      tw-items-center
      tw-gap-y-4
      tw-py-8
      tw-rounded
      tw-border
      tw-border-gray-200
      tw-bg-gray-100
      tw-my-10
    "
  >
    <h4 class="tw-text-center">Bind new device to site</h4>
    <div class="tw-flex tw-flex-col tw-items-start">
      <span class="tw-font-semibold">Commercial ID</span>
      <input
        type="text"
        class="form-control"
        v-model="com_id"
        placeholder="Ex: 42596"
      />
    </div>
    <div class="tw-flex tw-flex-row tw-items-center tw-gap-x-4">
      <button class="btn btn-sm btn-success" @click="save">
        <i class="fa fa-check"></i>
        Bind
      </button>
      <button class="btn btn-sm btn-default" @click="$emit('close', 'create')">
        <i class="fa fa-times"></i>
        Cancel
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    site: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    com_id: '',
  }),
  methods: {
    async save() {
      try {
        await this.$store.dispatch('rms/bindDevice', {
          site_id: this.site.id,
          com_id: this.com_id,
        })
        this.$emit('binded', +this.com_id)
      } catch (error) {
        console.log('device bind error', error)
      }
    },
  },
}
</script>

<style lang="scss" scoped>
</style>