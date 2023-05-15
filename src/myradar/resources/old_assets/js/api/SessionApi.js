export default class SessionApi {
  constructor() {}

  endpoint(path) {
    return `/customer/session/${path}`
  }

  async getSessions(user_id) {
    const res = await Vue.http.get(this.endpoint(`list?user_id=${user_id}`))
    return res.body
  }

  async removeSession(session_id) {
    const res = await Vue.http.post(this.endpoint('remove'), { session_id })
    return res.body
  }

  async logoutSession(session_id) {
    const res = await Vue.http.post(this.endpoint('logout'), { session_id })
    return res.body
  }
}
