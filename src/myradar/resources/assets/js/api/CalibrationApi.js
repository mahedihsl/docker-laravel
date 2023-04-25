export default class CalibrationApi {
    constructor(bus) {
        this.EventBus = bus;
    }

    getPriceFactor(carId) {
        Vue.http.get(`/car/meta-data/find/${carId}`).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('price-factor-found', response.body.data);
            } else {
                //
            }
        })
    }
    getPriceTuneFactor(carId){
      Vue.http.get(`/car/meta-data/find/price/tune/${carId}`).then(response => {
          if (response.body.status == 1) {
              this.EventBus.$emit('price-tune-factor-found', response.body.data);
          }
      })
    }

    updatePriceFactor(data) {
        Vue.http.post(`/car/meta-data/update`, data).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('price-factor-updated', response.body.data);
            } else {
                //
            }
        }, error => {})
    }

    updatePriceTuneFactor(data) {
        Vue.http.post(`/car/meta-data/tune/update`, data).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('price-tune-factor-updated', response.body.data);
            } else {
                //
            }
        }, error => {})
    }

    fuelCalibrationLog(carId) {
        Vue.http.get(`/fuel/calibration/log/${carId}`).then(response => {
            if (!!response.body.data.items) {
                this.EventBus.$emit('fuel-calibration-found', response.body.data.items);
            }
        }, error => {})
    }

    userFuelCalibrationLog(carId){
      Vue.http.get(`/user/fuel/calibration/log/${carId}`).then(response => {
          if (!!response.body.data) {
              this.EventBus.$emit('user-fuel-calibration-found', response.body.data);
          }
      }, error => {})
    }

    updateFuel(carId, data) {
        Vue.http.post('/fuel/calibration/save', {
            car_id: carId,
            data : JSON.stringify(data)
        }).then(response => {
            this.EventBus.$emit('fuel-log-saved');
        }, error => {});
    }

    deleteFuel(id) {
        Vue.http.post('/fuel/calibration/delete', {id}).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('fuel-log-deleted', id);
            }
        }, error => {})
    }

    gasCalibrationLog(carId) {
        Vue.http.get(`/gas/calibration/log/${carId}`).then(response => {
            this.EventBus.$emit('gas-calibration-found',
                            response.body.data.list.data,
                            response.body.data.type);
        }, error => {})
    }

    getGasMin(carId){
      Vue.http.get(`/gas/calibration/min/${carId}`).then(response => {
        this.EventBus.$emit('gas-min-found', response.body.data);
      }, error => {})
    }

    getRefuelInput(carId){
      Vue.http.get(`/gas/refuel/input/${carId}`).then(response => {
        this.EventBus.$emit('gas-refuel-input-found', response.body.data);
      }, error => {})
    }

    saveGasMin(carId, gasMin){
      Vue.http.get(`/gas/calibration/min/save/${carId}/${gasMin}`).then(response => {
        this.EventBus.$emit('gas-min-saved', response.body.data);
      }, error => {})
    }

    updateGas(carId, data) {
        Vue.http.post('/gas/calibration/save', {
            car_id: carId,
            data : JSON.stringify(data)
        }).then(response => {
            this.EventBus.$emit('gas-log-saved');
        }, error => {});
    }

    deleteGas(id) {
        Vue.http.post('/gas/calibration/delete', {id}).then(response => {
            if (response.body.status == 1) {
                this.EventBus.$emit('gas-log-deleted', id);
            }
        }, error => {})
    }

}
