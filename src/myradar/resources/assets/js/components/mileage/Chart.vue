<template lang="html">
    <div class="row">
        <div class="col-md-12">
            <canvas id="mileage-chart" width="400" height="200"></canvas>
        </div>
    </div>
</template>

<script>
export default {
    props: ['items'],
    data: function() {
        return {
            colors: [
                [120, 144, 156],
                [102, 187, 106],
                [38, 198, 218],
                [92, 107, 192],
                [92, 107, 192],
                [255, 167, 38],
                [255, 112, 67],
                [239, 83, 80],
            ]
        };
    },
    mounted: function() {
        var context = document.getElementById("mileage-chart").getContext('2d');
        var myChart = new Chart(context, {
            type: 'bar',
            data: {
                labels: this.getLabels(),
                datasets: [{
                    label: 'Distance in KM',
                    data: this.getValues(),
                    backgroundColor: this.getBodyColors(),
                    borderColor: this.getBorderColors(),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    },

    methods: {
        getLabels() {
            return this.items.map(el => el.date);
        },

        getValues() {
            return this.items.map(el => el.value);
        },

        getBodyColors() {
            return this.items.map(el => {
                return this.getBodyColor(this.getMatchedColor(el.value));
            });
        },

        getBorderColors() {
            return this.items.map(el => {
                return this.getBorderColor(this.getMatchedColor(el.value));
            });
        },

        getMatchedColor(d) {
            if (d < 5) {
                return this.colors[0];
            } else if (d < 10) {
                return this.colors[1];
            } else if (d < 20) {
                return this.colors[2];
            } else if (d < 30) {
                return this.colors[3];
            } else if (d < 40) {
                return this.colors[4];
            } else if (d < 50) {
                return this.colors[5];
            } else if (d < 60) {
                return this.colors[6];
            } else {
                return this.colors[7];
            }
        },

        getBorderColor(rgb) {
            return 'rgba(' + rgb.join() + ', 1)';
        },

        getBodyColor(rgb) {
            return 'rgba(' + rgb.join() + ',0.2)';
        }
    }
}
</script>

<style lang="css">
</style>
