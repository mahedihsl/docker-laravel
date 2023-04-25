export default class FenceApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    getFenceLog() {
        Vue.http.get('/get/fence/log').then(response => {
            if (response.body.status == 1) {
                if (response.body.data.length) {
                    this.EventBus.$emit('fence-log-found', response.body.data);
                } else {
                    this.EventBus.$emit('no-data-found');
                }
            }
        }, error => {})
    }

    getDistrictList() {
        Vue.http.get('/district/list').then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('district-list-found', response.body.data.items);
            }
        }, error => {})
    }

    getThanaList(districtId) {
        Vue.http.get(`/thana/list/${districtId}`).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('thana-list-found', response.body.data.items);
            }
        }, error => {});
    }

    getFenceList(thanaId) {
        Vue.http.get('/fence/list/' + thanaId).then(response => {
            setTimeout(function() {
                if (response.body.status == 1) {
                    this.EventBus.$emit('fence-list-found', response.body.data);
                }
            }.bind(this), 1000);
        });
    }

    toggleFence(fenceId, flag) {
        Vue.http.post('/fence/toggle', {
            fence_id: fenceId,
            flag: flag,
        }).then(response => {
            console.log('toggle response');
            console.log(response);
            setTimeout(function() {
                if (response.body.status == 1) {
                    this.EventBus.$emit('fence-toggled', fenceId, flag);
                }
            }.bind(this), 1000);
        });
    }

    removeFence() {

    }
}
