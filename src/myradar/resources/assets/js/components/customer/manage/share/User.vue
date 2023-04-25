<template>
  <tr>
    <td>{{serial}}</td>
    <td>{{user.name}}</td>
    <td>
      <button class="btn btn-success btn-sm" @click="share(user.id)" v-if="!shared">Share</button>
      <button class="btn btn-danger btn-sm" @click="revoke(user.id)" v-if="shared">Revoke</button>
    </td>
  </tr>
</template>
<script>
import {mapActions} from 'vuex';
import EventBus from '../../../../util/EventBus';

export default {
  props: ['serial', 'user', 'shared'],
  data: () => ({

  }),
  mounted() {
    EventBus.$on('car-share-success', this.onShareSuccess.bind(this));
    EventBus.$on('car-share-failed', this.onShareFailed.bind(this));
  },
  methods: {
    ...mapActions('share', ['share', 'revoke', 'getSharedUsers']),
    onShareSuccess(id) {
      if (id == this.user.id) {
        // TODO:
        this.getSharedUsers();
      }
    },
    onShareFailed(id, message) {
      if (id == this.user.id) {
        // TODO:
      }
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
