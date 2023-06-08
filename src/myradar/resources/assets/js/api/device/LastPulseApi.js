export default class LastPulseApi {
    constructor() {

    }

    static stats(day) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/lastpulse/stats`, {params: {day}})
                        .then(response => resolve(response.body.data), error => reject())
        })
    }

    static list(tag, day) {
        return new Promise((resolve, reject) => {
            Vue.http.get(`/lastpulse/items`, {params: {tag, day}})
                        .then(response => resolve(response.body.data), error => reject())
        })
    }

	static updateResetCall(id, ring) { // ring = 0 or 1
		return new Promise((resolve, reject) => {
            Vue.http.post(`/lastpulse/update`, {id, ring})
                        .then(response => resolve(response.body), error => reject())
        })
	}
}
