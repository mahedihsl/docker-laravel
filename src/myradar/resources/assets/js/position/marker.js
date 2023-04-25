export class Marker {
    constructor(point, callBack, callBack2, { iconForIgnitionOn, iconForIgnitionOff }) {
        this.iconForIgnitionOn = iconForIgnitionOn
        this.iconForIgnitionOff = iconForIgnitionOff

        this.icon = iconForIgnitionOn;
        this.marker = null;
        this.lastPoint = null; // type: Point
        this.currentPoint = point; // type: Point
        this.onAnimationOver = callBack;
        this.onEachStep = callBack2;

        this.deltaLat = 0;
        this.deltaLng = 0;
        this.currentStep = 0;
        this.timeoutId = null;
    }

    getCurrentPoint() {
        return this.currentPoint;
    }

    getLastPoint() {
        return this.lastPoint;
    }

    setCurrentPoint(point) {
        this.lastPoint = this.currentPoint;
        this.currentPoint = point;
        this.animateMarker();
    }

    animateMarker() {
        this.currentPoint.calcSteps(this.lastPoint);

        this.deltaLat = this.currentPoint.getPosition().lat() - this.lastPoint.getPosition().lat();
        this.deltaLng = this.currentPoint.getPosition().lng() - this.lastPoint.getPosition().lng();

        this.deltaLat /= this.currentPoint.getStepCount();
        this.deltaLng /= this.currentPoint.getStepCount();

        this.currentStep = 0;
        this.animationStep();
    }

    animationStep() {
        this.currentStep++;

        let prev = this.marker.getPosition();
        let next = new google.maps.LatLng(
            prev.lat() + this.deltaLat,
            prev.lng() + this.deltaLng,
        );

        if (this.currentStep == 1) {
            this.changeRotation(prev, next);
        }

        this.moveTo(next);
        // console.log('onEachStep');
        this.onEachStep(next);

        if (this.currentStep < this.currentPoint.getStepCount()) {
            this.timeoutId = setTimeout(
                this.animationStep.bind(this),
                this.currentPoint.getStepDelay()
            );
        } else {
            this.moveTo(this.getCurrentPoint().getPosition());
            this.timeoutId = null;
            this.onAnimationOver(this.getCurrentPoint());
        }
    }

    stopAnimation() {
        this.currentStep = 0;
        if (this.timeoutId != null) {
            clearTimeout(this.timeoutId);
        }
    }

    moveTo(position) {
        this.marker.setPosition(position);
    }

    changeRotation(pos1, pos2) {
        let angle = google.maps.geometry.spherical.computeHeading(pos1, pos2);
        this.icon.rotation = angle;
        this.marker.setIcon(this.getIcon());
    }

    setAsRed(flag) {
        let angle = this.icon.rotation;
        this.icon = flag ? this.iconForIgnitionOff : this.iconForIgnitionOn;
        this.icon.rotation = angle;
        this.marker.setIcon(this.getIcon());
    }

    removeFromMap() {
        this.marker.setMap(null);
    }

    getIcon() {
        return this.icon;
    }

    renderOn(map, label = null) {
        this.marker = map.addMarker(this, label);
    }

    getMarkerPosition() {
        var pos = this.currentPoint.getPosition();
        return pos;
    }
}
