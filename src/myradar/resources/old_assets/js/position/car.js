import { iconBlack, iconRed, makeVesselIcon } from './icon.js';

import PositionApi from '../api/tracking/PositionApi';
import CarApi from '../api/enterprise/CarApi';

import { Marker } from './marker.js';
import { Util } from './util.js';
import { Point } from './point.js';
import { Route } from './route.js';

export class Car {
    constructor(deviceId, enterprise = false) {
        this.enterprise = enterprise;
        this.deviceId = deviceId;
        this.totalFetched = 0;
        this.currentIndex = -1;
        this.points = []; // array of Point objects
        this.allDataFetched = false;
        this.speedFactor = 1;
        this.speedFactorChanged = false;
        this.boundary = {};
        this.trackIndex = 0;

        this.map = null;
        this.marker = null;
        this.route = null;

        this.startTime = null;
        this.finishTime = null;

        this.liveMode = false;

        this.thresholdDistance = 10; // distance in meters under which all points will be discarded
        this.moveAttemptInterval = 100; // time in milliseconds after which car will check is data is fetched

        this.vehicleType = 1 // by default: Car
    }

    setVehicleType(type) {
        this.vehicleType = type
    }

    setSpeedFactor(factor) {
        this.speedFactorChanged = true;
        this.speedFactor = factor;
    }

    startPastTracking(start, finish) {
        this.liveMode = false;

        this.setTimeRange(start, finish);

        this.totalFetched = 0;
        this.currentIndex = -1;
        this.points = [];
        this.trackIndex++;
        this.allDataFetched = false;

        if (this.marker != null) {
            this.marker.stopAnimation();
            this.removeFromMap();
            this.marker = null;
        }

        this.route.clear();
        this.getPastPositions(this.trackIndex);
    }

    startLiveTracking(mapBound = null, numOfCars) {
        this.liveMode = true;
        this.route.clear();
        mapBound = this.getLastPosition(mapBound, numOfCars);

        return mapBound;
    }

    getLastPosition(mapBound, numOfCars) {
        PositionApi.last(this.getDeviceId())
            .then(data => {
                if (this.enterprise == true) {
                    return CarApi.assignment(this.getDeviceId(), data)
                }

                return new Promise((resolve, reject) => {
                    resolve({ data: data, ass: null });
                });
            })
            .then(result => {
                let point = new Point(result.data.pos);
                if (this.marker == null) {
                    mapBound = this.makeMarker(point, result.ass, mapBound, numOfCars);
                } else {
                    this.marker.stopAnimation();
                    this.marker.moveTo(point.getPosition());
                    if (this.enterprise == true && numOfCars > 1) {
                        mapBound = this.map.fitBoundaryForCars(point, mapBound);
                    }
                    else {
                        this.map.updateCenter(point);
                    }

                }
                // let idle = (moment().unix() - response.data.time) > 120;
                let idle = !result.data.meta.engine ? true : false;
                this.setAsRed(idle);
                let time = this.enterprise ? null : result.data.pos.time;
                this.updateTimeStamp(time);
            })
        // $.get('/car/last/position/' + this.getDeviceId(), response => {
        //     if (response.status == 1) {
        //         let point = new Point(response.data.pos);
        //         if (this.marker == null) {
        //             this.makeMarker(point);
        //         } else {
        //             this.marker.stopAnimation();
        //             this.marker.moveTo(point.getPosition());
        //             this.map.updateCenter(point);
        //         }
        //         // let idle = (moment().unix() - response.data.time) > 120;
        //         let idle = !response.data.meta.engine ? true : false;
        //         this.setAsRed(idle);
        //         this.updateTimeStamp(response.data.time);
        //     }
        // });

        return mapBound;
    }

    isLiveMode() {
        return this.liveMode;
    }

    getDeviceId() {
        return this.deviceId;
    }

    setTimeRange(start, finish) {
        this.startTime = moment(start, 'D MMM Y hh:mm A');
        this.finishTime = moment(finish, 'D MMM Y hh:mm A');
    }

    getPastPositions(index) {
        $('#btn_history')
            .removeClass('fa-search')
            .addClass('fa-refresh')
            .addClass('fa-spin');

        $.get(this.getApiEndpoint(), res => {
            $('#btn_history')
                .removeClass('fa-spin')
                .removeClass('fa-refresh')
                .addClass('fa-search');
            if (this.trackIndex != index) {
                return;
            }

            let response = res.data.items || [];
            let len = response.length;

            this.boundary.minLat = 9999999, this.boundary.minLng = 9999999, this.boundary.maxLat = 0, this.boundary.maxLng = 0; //  adjust map for recorded tracking

            if (len > 0) {
                this.totalFetched += len;

                for (var i = 0; i < len; i++) {
                    let point = new Point(response[i]);
                    let valid = !this.points.length ||
                        this.points.slice(-1).pop()
                            .getPosition()
                            .distanceFrom(point.getPosition())
                        >= this.thresholdDistance;
                    if (valid) {
                        this.points.push(point);
                        this.boundary.minLat = Math.min(this.boundary.minLat, point.getPosition().lat());
                        this.boundary.minLng = Math.min(this.boundary.minLng, point.getPosition().lng());
                        this.boundary.maxLat = Math.max(this.boundary.maxLat, point.getPosition().lat());
                        this.boundary.maxLng = Math.max(this.boundary.maxLng, point.getPosition().lng());
                        //console.log(boundary.minLat, ' ', boundary.minLng, ' ', boundary.maxLat, ' ', boundary.maxLng, ' ', point.getPosition().lat(), ' ', point.getPosition().lng());
                    }
                }
                //console.log(this.points);

                if (this.marker == null) {
                    /**
                     * Car animation is about to start
                     */
                    this.speedFactorChanged = true;
                    this.makeMarker(this.points[0]);
                    this.marker.setAsRed(false);
                    this.moveCar();
                }

                this.allDataFetched = true;
            } else {
                $.confirm({
                    title: 'Sorry',
                    content: 'We could not find any data between your time lapse',
                    type: 'red',
                    theme: 'material',
                    buttons: {
                        cancel: {
                            text: 'Close'
                        }
                    }
                });
                this.allDataFetched = true;
            }
        });
    }

    moveCar() {
        if (this.currentIndex == this.points.length - 1) {
            if (this.allDataFetched == false) {
                setTimeout(this.moveCar.bind(this), this.moveAttemptInterval);
            }
            return;
        }

        let point = this.points[++this.currentIndex];
        point.setSpeedFactor(this.speedFactor);
        this.marker.setCurrentPoint(point);


        if (this.speedFactorChanged) {
            this.map.adjustZoom(this.speedFactor, point, this.boundary);
            this.speedFactorChanged = false;
        }
    }

    moveInLiveMode(data) {
        if (this.marker == null) {
            /**
             * Last position is not fetched yet, so wait for last position to be found
             */
            return;
        }
        this.marker.setAsRed(false);
        this.marker.setCurrentPoint(new Point(data));
    }

    updateTimeStamp(time) {
        let target = $('#map_clock strong');
        if (time == null) {
            target.text(moment().format('hh:mm A'));
        } else {
            time = moment(time * 1000);
            let now = moment();
            let format = 'hh:mm A';
            if (now.dayOfYear() != time.dayOfYear()) {
                format += ', D MMM';
            }
            target.text(time.format(format));
        }
    }

    onAnimationOver(point) {
        if (this.enterprise == true) {
            //dont update the boundary
        }
        else {
            this.map.updateBoundary(point);
        }
        this.updateTimeStamp(point.getTime());
        if (this.isLiveMode()) {
            // TODO: live mode animation over
        } else {
            this.moveCar();
        }
    }

    onEachAnimationStep(latlng) {
        // console.log('on each animation step: ' + latlng);
        if (!this.isLiveMode()) {
            // console.log('adding dot');
            this.route.addDot(latlng, this.map);
        }
    }

    getIconForIgnitionOn() {
        switch (this.vehicleType) {
            case 7:
                return makeVesselIcon()
            case 8:
                return makeVesselIcon()
            default:
                return iconBlack
        }
    }

    getIconForIgnitionOff() {
        switch (this.vehicleType) {
            case 7:
                return makeVesselIcon()
            case 8:
                return makeVesselIcon()
            default:
                return iconRed
        }
    }

    makeMarker(point, ass = null, mapBound = null, numOfCars = 1) {
        const options = {
            iconForIgnitionOn: this.getIconForIgnitionOn(),
            iconForIgnitionOff: this.getIconForIgnitionOff()
        }
        this.marker = new Marker(point,
            this.onAnimationOver.bind(this),
            this.onEachAnimationStep.bind(this),
            options
        );
        let label = null;
        if (ass != null) {
            if (ass.info != null) {
                label = {
                    labelContent: "Booked",
                    labelAnchor: new google.maps.Point(25, 45),
                    labelClass: "marker-label", // the CSS class for the label
                    labelInBackground: false,
                    ass: ass,
                };
            } else {
                label = {
                    labelContent: "",
                    labelAnchor: new google.maps.Point(25, 45),
                    labelClass: "hidden-label", // the CSS class for the label
                    labelInBackground: true,
                    ass: ass,
                };
            }
        }

        this.marker.renderOn(this.map, label);
        if (this.enterprise == true && numOfCars > 1) {
            //console.log("came in makeMarker");
            mapBound = this.map.fitBoundaryForCars(point, mapBound);
        }
        else {
            this.map.updateCenter(point);
        }

        return mapBound;

    }

    removeFromMap() {
        this.marker.removeFromMap();
    }

    setAsRed(idle = true) {
        this.marker.setAsRed(idle);
    }

    getApiEndpoint() {
        return '/car/positions/'
            + this.deviceId + '/'
            + this.startTime.unix() + '/'
            + this.finishTime.unix() + '/'
            + this.totalFetched;
    }

    setMap(m) {
        this.map = m;
        this.route = new Route();
    }

    getMap() {
        return this.map;
    }

    getCarPosition() {

        var pos = this.marker.getMarkerPosition();
        return pos;
    }
}
