export class Route {
    constructor() {
        this.drawInterval = 10;
        this.path = [];
        this.polyList = [];
    }

    addDot(pos, map) {
        // console.log('adding dots');
        if (this.path.length < this.drawInterval) {
            this.path.push({
                lat: pos.lat(),
                lng: pos.lng(),
            });
            // console.log('returns ... dot list short');
            return;
        }

        let len = this.path.length;
        let temp = this.path[len - 1];

        let poly = new google.maps.Polyline({
            path: this.path,
            geodesic: true,
            strokeColor: '#3F51B5',
            strokeOpacity: 1.0,
            strokeWeight: 4,
        });

        poly.setMap(map.getMap());
        this.polyList.push(poly);

        // console.log('drawing new line');

        this.path = [];
        this.path.push(temp);
    }

    clear() {
        for (var i = 0; i < this.polyList.length; i++) {
            this.polyList[i].setMap(null);
        }
        this.polyList = [];
        this.path = [];
    }
}
