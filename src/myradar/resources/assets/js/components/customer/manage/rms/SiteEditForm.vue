<template>
  <div class="tw-w-full tw-flex tw-flex-col">
    <h4>Edit site information</h4>
    <div class="tw-w-full tw-flex tw-flex-col tw-items-center tw-gap-y-5">
      <div class="tw-flex tw-flex-col tw-items-start">
        <span class="tw-font-semibold">Site Name</span>
        <input
          type="text"
          class="form-control"
          v-model="info.name"
          placeholder="Ex: Factory building 1"
        />
      </div>
      <div class="tw-flex tw-flex-row tw-items-center tw-gap-x-4">
        <button class="btn btn-sm btn-success" @click="save">Save</button>
        <button
          class="btn btn-sm btn-default"
          @click="$emit('close', 'create')"
        >
          Cancel
        </button>
      </div>
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
    info: {
      id: '',
      name: '',
    },
  }),
  mounted() {
    this.info = { id: this.site.id, name: this.site.name }
  },
  methods: {
    async save() {
      try {
        await this.$store.dispatch('rms/updateSite', this.info)
        this.$emit('updated')
      } catch (error) {
        console.log('site save error', error)
      }
    },
  },
}
</script>

<style lang="scss" scoped>
</style>