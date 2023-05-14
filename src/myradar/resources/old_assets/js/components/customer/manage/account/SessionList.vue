<template>
  <div class="col-xs-12">
    <h3 v-if="empty">Empty</h3>
    <ul class="session-list">
      <SessionItem
        v-for="(session, i) in sessions"
        :key="i"
        :session="session"
        @remove="deleteSession"
        @logout="logoutSession"
      />
    </ul>
  </div>
</template>

<script>
import SessionApi from '../../../../api/SessionApi'
import SessionItem from './SessionItem'

export default {
  props: ['customer'],
  components: {
    SessionItem,
  },
  data: () => ({
    sessions: [],
    empty: false,
  }),
  mounted() {
    this.sessionApi = new SessionApi()
    this.fetchSessions()
  },
  methods: {
    async fetchSessions() {
      try {
        this.sessions = await this.sessionApi.getSessions(this.customer.id)
        this.empty = this.sessions.length == 0
      } catch (error) {
        console.log(`session list api error: ${error.message}`)
      }
    },
    async deleteSession(session_id) {
      try {
        await this.sessionApi.removeSession(session_id)
        await this.fetchSessions()
        toastr.success('Token Deleted successfully')
      } catch (error) {
        toastr.error(error.message)
      }
    },
    async logoutSession(session_id) {
      try {
        await this.sessionApi.logoutSession(session_id)
        await this.fetchSessions()
        toastr.success('Force logout command sent successfully')
      } catch (error) {
        toastr.error(error.message)
      }
    },
  },
}
</script>

<style scoped>
.session-list {
  list-style: none;
  padding-left: 0;
}
</style>
