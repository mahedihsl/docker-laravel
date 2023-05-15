const apiKey = 'AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ'

export default {
  data: () => ({
    scripts: [
      `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=geometry,places`,
      // `https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js`,
      // `https://cdnjs.cloudflare.com/ajax/libs/marker-animate-unobtrusive/0.2.8/vendor/markerAnimate.js`,
      // `https://cdnjs.cloudflare.com/ajax/libs/marker-animate-unobtrusive/0.2.8/SlidingMarker.min.js`,
    ],
    loadCount: 0,
  }),
  mounted() {
    if (!process.server) {
      if (typeof google === 'undefined') {
        for (const src of this.scripts) {
          const script = document.createElement('script')
          script.onload = this.onScriptLoaded.bind(this)
          script.type = 'text/javascript'
          script.src = src
          script.async = false
          document.head.appendChild(script)
        }
      } else {
        this.$emit('loaded')
      }
    }
  },
  methods: {
    onScriptLoaded() {
      this.loadCount += 1
      if (this.loadCount === this.scripts.length) {
        this.$emit('loaded')
      }
    },
  },
  render: () => null,
}
