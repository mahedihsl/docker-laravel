import {Util} from './util.js';

export class Point {
    constructor(p) {
        this.numSteps = 100; // number of steps
        this.delayStep = 10; // ms delay between steps
        this.speedFactor = 1;

        this.pos = Util.getLatLngObj(p);
        this.time = p.time;
    }

    getSpeedFactor() {
        return this.speedFactor;
    }

    setSpeedFactor(factor) {
        this.speedFactor = factor;
    }

    getPosition() {
        return this.pos;
    }

    getTime() {
        return this.time;
    }

    calcSteps(prev) {
        let deltaTime = this.getTime() - prev.getTime();
        let threshold = 5 * 60; // different trip after 5 min
        deltaTime = deltaTime > threshold ? 5 * this.getSpeedFactor() : deltaTime; // animate over 5 sec if threshold crossed
        this.numSteps = deltaTime * 1000;
        this.numSteps /= this.getStepDelay();
        this.numSteps /= this.getSpeedFactor();
    }

    getStepCount() {
        return this.numSteps;
    }

    getStepDelay() {
        return this.delayStep;
    }
}
