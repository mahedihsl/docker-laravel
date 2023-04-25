const icon = {
  url: 'http://myradar.com.bd/images/ic-pin@2x.png',
  // size: new google.maps.Size(64, 64),
  // scale: 0.5,
  scaledSize: new google.maps.Size(32, 32),
  // origin: new google.maps.Point(0, 0),
  // anchor: new google.maps.Point(0, 32),
}

export default class Pin extends google.maps.Marker {
  constructor(container, id, options) {
    super({ ...options, icon })
    this.uid = id
    this.container = container
    this.latlng = options.position

    this.addListener('drag', this.onDrag)
    this.addListener('click', this.onClick)
  }

  position() {
    return this.latlng
  }

  latLng() {
    return { lat: this.latlng.lat(), lng: this.latlng.lng() }
  }

  lngLat() {
    return [this.latlng.lng(), this.latlng.lat()]
  }

  onDrag(event) {
    this.latlng = event.latLng
    this.container.updatePolygon()
  }

  onClick(event) {
    this.container.removePin(this.uid)
  }
}
