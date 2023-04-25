import {Marker} from './marker';

export class Route {
    constructor() {
        this.path = [];
        this.markers = [];
        this.distMap = {};
        this.poly = null;
        this.createDistMap();
    }

    setPath(path) {
        this.path = path;
    }

    drawPath(map) {
        if (this.poly != null) {
            this.poly.setMap(null);
        }

        this.poly = new google.maps.Polyline({
            path: this.path,
            geodesic: true,
            strokeColor: '#3f51b5',
            strokeOpacity: 1.0,
            strokeWeight: 4,
        });

        this.poly.setMap(map);
    }

    removeMarkers() {
        for (let i = 0; i < this.markers.length; i++) {
            this.markers[i].remove();
        }
        this.markers = [];
    }

    rearrangeMarkers(map) {
        this.removeMarkers();

        let zoom = map.getZoom();

        console.debug('re-arranging markers', zoom);

        let minDist = 1000;
        let lastPos = null;
        console.log('minDist = ', minDist);
        this.markers.push(new Marker(this.path[0], map));
        let dist = 0;
        for (let i = 0; i < this.path.length; i++) {
            if (!i || i == this.path.length - 1
                || this.path[i].status != this.path[i - 1].status
                || this.distance(lastPos, this.path[i]) >= minDist) {
                this.markers.push(new Marker(this.path[i], map));
                lastPos = this.path[i];
            }
        }
    }

    distance(p1, p2) {
        let rad = function(x) {
            return x * Math.PI / 180;
        };
        const R = 6378137; // Earth’s mean radius in meter
        let dLat = rad(p2.lat - p1.lat);
        let dLong = rad(p2.lng - p1.lng);
        let a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(rad(p1.lat)) * Math.cos(rad(p2.lat)) *
        Math.sin(dLong / 2) * Math.sin(dLong / 2);
        let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        let d = R * c;
        return d; // returns the distance in meter
    }

    createDistMap() {
        this.distMap[22] = 5;
        this.distMap[21] = 10;
        this.distMap[20] = 25;
        this.distMap[19] = 50;
        this.distMap[18] = 100;
        this.distMap[17] = 200;
        this.distMap[16] = 400;
        this.distMap[15] = 700;
        this.distMap[14] = 1200;
        this.distMap[13] = 2500;
        this.distMap[12] = 3500;
        this.distMap[11] = 6500;
        this.distMap[10] = 13000;
        this.distMap[9] = 25000;
        this.distMap[8] = 45000;
        this.distMap[7] = 80000;
        this.distMap[6] = 140000;
        this.distMap[5] = 220000;
        this.distMap[4] = 330000;
        this.distMap[3] = 440000;
        this.distMap[2] = 600000;
        this.distMap[1] = 750000;
        this.distMap[0] = 900000;
    }
}
