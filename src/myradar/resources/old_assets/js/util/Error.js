export default class Error {
    constructor(error) {
        this.error = error.body;
    }

    validationError() {
        let ret = {};
        for (var key in this.error) {
            if (this.error.hasOwnProperty(key)) {
                ret[key] = this.error[key][0];
            }
        }
        return ret;
    }
}
