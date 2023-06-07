export default class FuelApi {
  constructor(bus) {
    this.EventBus = bus
  }

  latest(deviceId) {
    Vue.http.get(`/fuel/latest/${deviceId}`).then(
      response => {
        if (response.body.status == 1) {
          this.EventBus.$emit('latest-fuel-found', response.body.data)
        }
      },
      error => {}
    )
  }

  history(deviceId, days) {
    Vue.http.get(`/fuel/history/${deviceId}/${days}`).then(
      response => {
        if (response.body.status == 1) {
          this.EventBus.$emit('fuel-chart-found', response.body.data.items)
        }
      },
      error => {}
    )
  }

  async fetchGroups() {
    const res = await Vue.http.get(`/fuel/fetch-groups`)
    console.log(res)
    return res.body
  }
}
