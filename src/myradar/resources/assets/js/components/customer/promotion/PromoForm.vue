<template lang="html">
    <div class="form col-md-8 col-md-offset-2">

        <div class="form-group">
          <label for="amount">Scheme Name</label>
          <input type="text" class="form-control" id="name" v-model="name" placeholder="Name of this promo scheme">
          <p class="help-block"></p>
        </div>
        <div class="form-group">
          <label for="date">Valid Till</label>
          <datepicker v-model="date" name="uniquename" placeholder="Pick Date" input-class="form-control"></datepicker>
          <p class="help-block"></p>
        </div>
        <div class="form-group">
          <label for="amount">No of Free Months</label>
          <input type="text" class="form-control" id="month" v-model="freeMonth" placeholder="No of free months">
          <p class="help-block"></p>
        </div>

        <div class="form-group">
          <label for="amount">Discount in taka</label>
          <input type="text" class="form-control" id="discount" v-model="discount" placeholder="New customer's installation discount">
          <p class="help-block"></p>
        </div>

        <button type="button" class="btn btn-success pull-right save-button" v-on:click="save" :class="{disabled: loading}">
            <i class="fa fa-save"></i> Save
        </button>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import vSelect from "vue-select";

import moment from 'moment';

import PromotionApi from '../../../api/PromotionApi';
import EventBus from '../../../util/EventBus';

export default {
    components: {
        Datepicker,
        vSelect,
    },
    data: () => ({
        checked: [],
        name: '',
        date: '',
        loading: false,
        freeMonth: 1,
        discount:0,
    }),
    mounted() {
        EventBus.$on('scheme-save-start', this.onSaveStart.bind(this));
        EventBus.$on('scheme-save-finish', this.onSaveFinish.bind(this));
    },
    methods: {
        save() {
            let api = new PromotionApi(EventBus);
            api.saveScheme({
                name: this.name,
                freeMonth: this.freeMonth,
                date: moment(this.date).unix(),
                discount: this.discount,
            });
        },
        onSaveStart() {
            this.loading = true;
        },

        onSaveFinish(flag) {
            this.loading = false;
            if (flag) {
                toastr.success('Scheme saved successfully');
            } else {
                toastr.error('Error ! Try Again');
            }
        }
    }
}
</script>

<style lang="css">
.save-button {
    padding-left: 24px;
    padding-right: 24px;
}

</style>
