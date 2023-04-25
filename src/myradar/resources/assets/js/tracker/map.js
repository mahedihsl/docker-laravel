import {Route} from './route';
import TrackerApi from '../api/enterprise/TrackerApi';

export class Map {
    constructor(domId) {
        this.map = null;
        this.route = new Route();

        this.domId = domId;
        this.defaultZoom = 14;
        this.defaultCenter = new google.maps.LatLng(23.776750, 90.396653);
    }

    init(center = null) {
        this.map = new google.maps.Map(document.getElementById(this.domId), {
            zoom: this.defaultZoom,
            center: center ? center : this.defaultCenter,
            gestureHandling: 'greedy',
        });
        google.maps.event.addListenerOnce(this.map, 'idle', function(){
            // this.drawRoute();
        }.bind(this));

        this.map.addListener('zoom_changed', function() {
            // this.route.rearrangeMarkers(this.map);
        }.bind(this));
    }

    getData(deviceId, date) {
        TrackerApi.route(deviceId, date)
            .then(data => {
                this.drawRoute(data.path, data.events);
            });
    }

    drawRoute(path, events) {
        if (path.length) {
            this.map.setCenter(path[0]);
        }
        path = this.mergeStatus(path, events);

        this.route.setPath(path);
        this.route.drawPath(this.map);
        this.route.rearrangeMarkers(this.map);
    }

    mergeStatus(path, events) {
        let i = path.length - 1;
        let j = events.length - 1;
        let last;
        while (i > -1 && j > -1) {
            if (path[i].time >= events[j].time) {
                path[i--].status = events[j].status;
            } else {
                last = events[j--].status;
            }
        }
        i = 0;
        while (i < path.length && path[i].status == null) {
            path[i].status = !last;
        }
        return path;
    }
}
