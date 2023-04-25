<template>
  <div class="tw-w-full tw-flex tw-flex-col">
    <h4>Create a new site</h4>
    <div class="tw-w-full tw-flex tw-flex-col tw-items-center tw-gap-y-5">
      <div class="tw-flex tw-flex-col tw-items-start">
        <span class="tw-font-semibold">Site Name</span>
        <input
          type="text"
          class="form-control"
          v-model="name"
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
    userId: {
      type: String,
      required: true,
    },
    userUid: {
      type: Number,
      required: true,
    }
  },
  data: () => ({
    name: '',
  }),
  methods: {
    async save() {
      try {
        await this.$store.dispatch('rms/saveSite', {
          user_id: this.userId,
          user_uid: this.userUid,
          name: this.name,
        })
        this.$emit('saved')
      } catch (error) {
        console.log('site save error', error)
      }
    },
  },
}
</script>

<style lang="scss" scoped>
</style>