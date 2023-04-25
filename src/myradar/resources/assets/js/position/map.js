import Swal from 'sweetalert2'
import moment from 'moment'

export class Map {
    constructor(domId) {
        this.map = null;

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
            // fetchCars();
            // var bound = map.getBounds();
            // console.log(bound.getSouthWest().lat(), bound.getSouthWest().lng());
            // console.log(bound.getNorthEast().lat(), bound.getNorthEast().lng());
        });
    }

    updateBoundary(point) {
        let northEast = this.map.getBounds().getNorthEast();
        let southWest = this.map.getBounds().getSouthWest();
        let offsetLat = (northEast.lat() - southWest.lat()) / 15;
        let offsetLng = (northEast.lng() - southWest.lng()) / 15;

        northEast = new google.maps.LatLng(northEast.lat() - offsetLat, northEast.lng() - offsetLng);
        southWest = new google.maps.LatLng(southWest.lat() + offsetLat, southWest.lng() + offsetLng);
        let newBounds = new google.maps.LatLngBounds(southWest, northEast);
        if (!newBounds.contains(point.getPosition())) {
            this.map.panTo(point.getPosition());
        }
    }

    updateCenter(point) {
        this.map.panTo(point.getPosition());
    }

    addMarker(marker, label = null) {
        if (!label) {
            return new google.maps.Marker({
                position: marker.getCurrentPoint().getPosition(),
                title: 'Marker',
                map: this.map,
                icon: marker.getIcon(),
            });
        }

        let ret = new MarkerWithLabel({
            position: marker.getCurrentPoint().getPosition(),
            title: 'Marker',
            map: this.map,
            icon: marker.getIcon(),
            ...label,
        });

        const map = this.map;
        google.maps.event.addListener(ret, "click", function (e) {
            let html = null;

            if (label.ass.info == null) {
                let car = label.ass.car;
                let driver = car.driver ? car.driver.name : 'N/A';
                let phone = car.driver ? car.driver.phone : 'N/A';


                let content = `<div class="col-xs-12"><span class="mod-title-lg">Reg. No : ${car.name}</span></div>`;
                content += `<div class="col-xs-12"><span class="mod-content-lg">Driver : ${driver}</span></div>`;
                content += `<div class="col-xs-12"><span class="mod-helper-lg">Phone : ${phone}</span></div>`;

                if(car.driver != null){
                  content += `<div class="col-xs-12 vertical-space-medium"><a class="btn btn-primary" href="/driver/manage?assign=${car.driver.id}&previous=map"><i class="fa fa-plus"></i> Assign</a></div>`;
                }

                html = $('<div>', {class: 'content mod-wrapper', style: 'min-height: 100px; padding: 30px 20px;'})
                    .append(
                        $('<div>', {class: 'row'})
                            .append($('<div>', {
                                class: 'col-xs-6 col-xs-offset-3',
                                html: content
                            }))
                    );
            } else {
                let info = label.ass.info.data;
                let driver = `<span class="mod-title">Driver</span><br /><span class="mod-content">${info.driver.name} (Car: ${info.car.name})</span><br /><span class="mod-helper">${info.driver.phone}</span>`;

                let route = `<span class="mod-title">Route</span><br /><span class="mod-content">${info.start} - ${info.dest}</span><br /><span class="mod-helper"></span>`;

                let time = moment(info.from * 1000);
                let date = time.format('D MMM YYYY h:mm A');
                let dur = parseInt((info.to - info.from) / 3600);
                let dateTime = `<span class="mod-title">Date & Time</span><br /><span class="mod-content">${date}</span><br /><span class="mod-helper">${dur} Hours</span>`;

                let emp = info.employee ? info.employee.name : info.message;
                let emp1 = info.employee ? info.employee.phone : '';
                let type = info.type == 1 ? 'Officer' : 'Logistic';
                let task = `<span class="mod-title">Task: ${type}</span><br /><span class="mod-content">${emp}</span><br /><span class="mod-helper">${emp1}</span>`;
                let reassign = `<a href="/driver/manage?assign=${info.driver.id}&previous=map" class="btn btn-default btn-block">Reassign</a>`;

                html = $('<div>', {class: 'content mod-wrapper', style: 'min-height: 200px'})
                    .append(
                        $('<div>', {class: 'row'})
                        .append($('<div>', {class: 'col-xs-6 vertical-space-medium blue-right', html: driver}))
                        .append($('<div>', {class: 'col-xs-6 vertical-space-medium', html: route}))
                    )
                    .append(
                        $('<div>', {class: 'row'})
                        .append($('<div>', {class: 'col-xs-6 blue-right', html: dateTime}))
                        .append($('<div>', {class: 'col-xs-6', html: task}))
                    )
                    .append(
                        $('<div>', {class: 'row'})
                        .append($('<div>', {class: 'col-xs-6 col-md-2 col-md-offset-5', html: reassign}))
                    );
            }



            Swal({
                type: "info",
                title: label.ass.info == null ? "Vehicle Info" : "Assignemnt Info",
                html: html,
                width: '64rem',
            });
        });

        return ret;

    }

    getMap() {
        return this.map;
    }

    fitBoundaryForCars(point, mapBound){
        mapBound.extend(point.getPosition());
        this.map.fitBounds(mapBound);
        this.map.setCenter(mapBound.getCenter());
        //this.map.setZoom(this.map.getZoom()-1);
        return mapBound;
    }

    adjustZoom(speedFactor, point, boundary){
      if(speedFactor >= 100){

        let offsetLat = (boundary.maxLat - boundary.minLat) / 10  ;
        let offsetLng = (boundary.maxLng - boundary.minLng) / 10;
        //console.log(offsetLat, " ", offsetLng);
        let northEast = new google.maps.LatLng(boundary.maxLat , boundary.maxLng );
        let southWest = new google.maps.LatLng(boundary.minLat , boundary.minLng );

        let newBounds = new google.maps.LatLngBounds();
        newBounds.extend(northEast);
        newBounds.extend(southWest);
        this.map.fitBounds(newBounds);
        let centerLat = (boundary.minLat + boundary.maxLat)/2;
        let centerLng = (boundary.minlng + boundary.maxLng)/2;
        let center = new google.maps.LatLng(centerLat, centerLng);
        //this.map.setCenter(center);
        this.map.panTo(center.getPosition());
        //console.log("came to adjust zoom");
        //this.map.setCenter(point.getPosition());
      }
      else{
        if(this.map.getZoom() != this.defaultZoom){
          this.map.setZoom(this.defaultZoom);
          this.map.setCenter(point.getPosition());
        }
      }
    }

}
