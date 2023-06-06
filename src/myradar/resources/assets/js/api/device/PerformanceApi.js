export default class PerformanceApi {
    constructor() {

    }

    static stats(day) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/performance/stats`, {params: {day}})
                        .then(response => resolve(response.body), error => reject())
        })
    }

    static list(tag, day) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/performance/items`, {params: {tag, day}})
                        .then(response => resolve(response.body), error => reject())
        })
    }
}
