export class Util {
    constructor() {

    }

    static getLatLngObj(pos) {
        return new google.maps.LatLng(pos.lat, pos.lng);
    }
}
