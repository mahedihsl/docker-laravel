<template lang="html">
    <div class="col-md-6 col-md-offset-3">
        Create customer
        <keep-alive>
            <component
                :is="currentView"
                @next="goNext"
                @back="goBack">
            </component>
        </keep-alive>
    </div>
</template>

<script>
import NewCustomer from './form/NewCustomer.vue';
import NewCar from '../car/form/NewCar.vue';
import BindService from '../service/form/BindService.vue';
import Loader from '../util/Loader.vue';
import Hyp from '../util/hy-progress.vue';


export default {

    data: function() {
        return {
            comps: ['new-customer', 'new-car', 'bind-service','hy-progress' ],
            //loader
            compi: 0,
            info: {},
        }
    },
    computed: {
        currentView: function() {
            return this.comps[this.compi];
        }
    },
    components: {
        'new-customer': NewCustomer,
        'new-car': NewCar,
        'bind-service': BindService,
        'hy-progress' :Hyp
        //'loader': Loader,
    },
    mounted: function() {

    },
    methods: {
        goNext() {
          // console.log("test");
            this.compi++;
        },
        goBack() {
            this.compi--;
        }
    }
}
</script>

<style lang="css">
</style>
