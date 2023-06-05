<template>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="toptitle col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>Analytics</h4>
        </div>
        <!-- <car-count :customer="customer.id"> </car-count> -->
        <last-used :customer="customer.id"> </last-used>
        <vehicles-table :cars="cars" @click="onCarClick"></vehicles-table>
        <last-position></last-position>
        <mileage
            v-if="selectedCarId"
            :car-id="selectedCarId"
            :subscribed="true"
        ></mileage>
    </div>
</template>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
<script>
import LastUsed from "./LastUsed.vue";
import VehiclesTable from "./VehiclesTable.vue";
import LastPosition from "./LastPosition.vue";
import Mileage from "../../service/Mileage.vue";
import EventBus from "../../../../util/EventBus";
import CustomerApi from "../../../../api/CustomerApi";

export default {
    props: ["customer"],
    data: () => ({
        cars: [],
        noOfCars: 0,
        selectedCarId: ""
    }),
    mounted() {
        EventBus.$on("car-names-found", this.carNamesFound.bind(this));

        let api = new CustomerApi(EventBus);
        api.cars(this.customer.id);

        this.$store.dispatch("car/getCarsOfUser", this.customer.id);
    },

    components: {
        Mileage,
        LastUsed,
        VehiclesTable,
        LastPosition
    },
    methods: {
        carNamesFound(data) {
            this.cars = data;
            this.noOfCars = data.length;
            if (data.length) {
                this.onCarClick(data[0]);
            }
        },
        onCarClick(car) {
            this.$store.dispatch("car/getLastLocation", car.id);
            this.selectedCarId = car.id;
        }
    }
};
</script>
<style lang="scss">
.cardleftbar {
    background-color: #2196f3;
    text-align: center;
    vertical-align: middle;
    position: relative;
    height: 100%;
    color: #ffebee;
    width: 25%;
}
.leftbarspan {
    font-size: 16px;
    display: inline;
}
.cardleftbar h1 {
    font-size: 40px;
    margin: 0;
    position: relative;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
table {
    width: 100%;
}
td,
th {
    padding: 5px;
    text-allign: left;
    font-size: 105%;
}
.toptitle {
    border-bottom: 1px solid #e0e0e0;
    margin-bottom: 10px;
}
.noofcars {
    position: relative;
}
.vehiclestitle {
    border-bottom: 1px solid #e0e0e0;
    height: 15%;
}
.card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.16),
        0 2px 10px 0 rgba(0, 0, 0, 0.12);
    transition: 0.3s;
}

.card:hover {
    box-shadow: 0 16px 32px 0 rgba(0, 0, 0, 0.2);
}
.topcard {
    height: 125px;
}
.bottomcard {
    height: 260px;
}
.card {
    margin-top: 5px;
    margin-bottom: 5px;
    box-sizing: border-box;
    border-radius: 2px;
    background-clip: padding-box;
    width: 100%;
}
.card span.card-title {
    color: #fff;
    font-size: 24px;
    font-weight: 300;
    text-transform: uppercase;
}

.card .card-image {
    position: relative;
    overflow: hidden;
}
.card .card-image img {
    border-radius: 2px 2px 0 0;
    background-clip: padding-box;
    background-position: center;
    position: relative;
    z-index: -1;
    width: 100%;
}
.card .card-image span.card-title {
    position: absolute;
    bottom: 0;
    left: 0;
    padding: 16px;
}
.card .top {
    padding: 16px;
    border-radius: 0 0 2px 2px;
    background-clip: padding-box;
    box-sizing: border-box;
    width: 75%;
    height: 100%;
}
.top h4 {
    font-size: 20px;
}
.card .card-content {
    padding: 16px;
    border-radius: 0 0 2px 2px;
    background-clip: padding-box;
    box-sizing: border-box;
    width: 100%;
}

.card-content {
    height: 85%;
}
.card .top p {
    color: #9e9e9e;
    font-size: 14px;
}
.card .card-content span.card-title {
    line-height: 48px;
}
</style>
