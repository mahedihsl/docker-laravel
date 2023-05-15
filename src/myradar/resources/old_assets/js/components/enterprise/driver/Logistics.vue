<template>
  <div>
    <h4>Logistics Assignment</h4>
    <textarea rows="4" class="form-control v-margin" v-model="message" placeholder="Type your message"></textarea>
  </div>
</template>
<script>
export default {
  data: () => ({
    message: '',
  }),
  watch: {
    message: function(val) {
      this.$store.commit('message', val)
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
