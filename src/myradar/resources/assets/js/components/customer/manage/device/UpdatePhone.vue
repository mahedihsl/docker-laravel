<template>
    <div class="row">
        <div class="col-xs-12">
            <button class="btn btn-link pull-right" @click="onBackClick">
                <i class="fa fa-arrow-left"></i> Back
            </button>
        </div>
        <div class="col-xs-12 col-md-6 col-md-offset-3">
            <div class="form">
                <div class="form-group">
                    <label for="">New Phone Number</label>
                    <input type="text" class="form-control" placeholder="017xx-xxxxxx" v-model="phone">
                    <p class="help-block text-danger">{{error}}</p>
                </div>
                <button class="btn btn-success pull-right" @click="onUpdateClick">
                    <i class="fa fa-refresh fa-spin" v-show="loading"></i> Update
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import DeviceApi from '../../../../api/DeviceApi';

export default {
    props: ['vehicle'],
    data: () => ({
        phone: '',
        error: '',
        loading: false,
    }),
    mounted() {
        EventBus.$on('device-phone-updated', this.onSuccess.bind(this));
        EventBus.$on('device-phone-update-error', this.onError.bind(this));
    },
    methods: {
        onUpdateClick() {
            if (this.validate()) {
                this.loading = true;
                let api = new DeviceApi(EventBus);
                api.updatePhone(this.vehicle.id, this.phone);
            }
        },

        validate() {
            if (this.phone.length < 11) {
                this.error = 'Invalid Phone Number';
                return false;
            }

            this.error = '';
            return true;
        },

        onSuccess() {
            this.loading = false;
            this.onBackClick();
        },

        onError(message) {
            toastr.error(message);
            this.onBackClick();
        },

        onBackClick() {
            EventBus.$emit('show-car-list');
        }
    }
}
</script>
<style scoped>
</style>
