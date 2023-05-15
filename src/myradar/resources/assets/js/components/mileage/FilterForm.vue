<template lang="html">
    <div class="row">
        <div class="col-md-4">
            <v-select :on-change="onCarChanged" :value.sync="selectedCar" :options="cars" placeholder="Choose Car"></v-select>
        </div>
        <div class="col-md-4">
            <v-select :on-change="onDayChanged" :value.sync="selectedDay" :options="days" placeholder="Time Range"></v-select>
        </div>
    </div>
</template>

<script>
import vSelect from "vue-select";

import EventBus from '../../util/EventBus';
import Api from '../../api/MileageApi';

export default {
    data: function() {
        return {
            userId: null,
            selectedCar: null,
            selectedDay: null,
            cars: [],
            days: [],
        };
    },
    components: {
        vSelect,
    },
    mounted: function() {
        this.userId = $('input[name="userid"]').val();
        this.initDays();

        EventBus.$on('cars-found', this.onCarsFound.bind(this));

        let api = new Api(EventBus);
        api.getCars(this.userId);

    },
    methods: {
        onCarsFound(list) {
            list.forEach(el => {
                this.cars.push({
                    value: el.id,
                    label: el.name,
                });
            });
            this.selectedCar = this.cars[0];
            this.onFilterChanged();
        },

        initDays() {
            [7, 15, 20, 30].forEach(el => {
                this.days.push({
                    value: el,
                    label: el + ' Days',
                });
            });
            this.selectedDay = this.days[0];
        },

        onCarChanged(val) {
            this.selectedCar = val;
            this.onFilterChanged();
        },

        onDayChanged(val) {
            this.selectedDay = val;
            this.onFilterChanged();
        },

        onFilterChanged() {
            if (this.selectedDay && this.selectedCar) {
                let api = new Api(EventBus);
                api.getRecords(this.selectedCar.value, this.selectedDay.value);
            }
        }
    }
}
</script>

<style lang="css">
</style>
