import {greenCar, redCar} from './icon';

export class Marker {
    constructor(data, map = null) {
        this.position = {
            lat: data.lat,
            lng: data.lng,
        };
        this.time = data.time;
        this.status = data.status;
        this.marker = null;

        if (map != null) {
            this.render(map);
        }
    }

    render(map) {
        if (this.marker == null) {
            this.marker = new google.maps.Marker({
                position: this.position,
                map: map,
                title: 'Car',
                icon: this.status ? greenCar : redCar,
            });
        } else {
            this.marker.setMap(map);
        }
    }

    remove() {
        if (this.marker != null) {
            this.marker.setMap(null);
        }
    }
}
