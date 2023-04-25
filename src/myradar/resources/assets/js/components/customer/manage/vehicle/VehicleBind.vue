<template>
  <div class="row">
    <div class="row header">
      <div class="col-md-12">
        <h4 class="text-center text-primary">Bind Device for Car: {{vehicle.reg_no}}</h4>
        <hr>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-6 col-md-offset-3">
        <div class="form">
          <div class="form-group">
            <label>Commercial ID</label>
            <input type="text" v-model="com_id" class="form-control" placeholder="ex: 28540">
            <span class="helper-text text-danger">{{error.com_id}}</span>
          </div>
          <div class="col-md-12">
            <h4>Bind Services</h4>
            <ul class="service-list">
                <service v-for="(s, i) in services" :service="s" :car-id="vehicle.id" :key="i"></service>
            </ul>
          </div>
          <div class="pull-right" style="margin-bottom: 20px;">
            <button class="btn btn-success" :class="{disabled: spinner}" @click="save" v-if="!done">
              <i class="fa fa-refresh fa-spin" v-if="spinner"></i>
              <i class="fa fa-check" v-if="!spinner"></i> Save
            </button>
            <button class="btn btn-default" :class="{disabled: spinner}" @click="cancel" v-if="!done">
              <i class="fa fa-times"></i> Cancel
            </button>
            <button class="btn btn-primary" @click="cancel" v-if="done">
              <i class="fa fa-check" v-if="!spinner"></i> Done
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import EventBus from '../../../../util/EventBus';
import CarApi from '../../../../api/CarApi';

import Service from './ServiceItem.vue';

export default {
    props: ['vehicle'],
    components: {
        Service,
    },
    data: () => ({
        com_id: '',
        binds: [],
        error: {},
        done: false,
        spinner: false,
        services: [],
    }),
    mounted() {
        EventBus.$on('car-bind-done', this.onBindComplete.bind(this));
        EventBus.$on('car-bind-failed', this.onBindFailed.bind(this));
        EventBus.$on('car-services-found', this.onServicesFound.bind(this));

        // TODO: remove getServices call
        let api = new CarApi(EventBus);
        api.getServices(this.vehicle.id);
    },
    methods: {
        save() {
            let error = this.validate();
            if (error) return;

            this.spinner = true;
            let api = new CarApi(EventBus);
            api.bindDevice({
                car_id: this.vehicle.id,
                com_id: this.com_id,
            });
        },
        cancel() {
            EventBus.$emit('show-car-list');
        },
        validate() {
            let message = null;
            if (this.com_id.trim().length == 0) {
                message = 'Please Type a Commercial ID';
            }

            if (message) {
                $.alert({
                    title: 'Error !',
                    content: message,
                    type: 'red',
                    theme: 'material',
                });

                return true;
            }

            return false;
        },
        onServicesFound(list) {
            this.services = list;
        },
        onBindComplete() {
            this.spinner = false;
            this.done = true;
            toastr.success('Device Successfully Binded', 'Congrats !');
        },
        onBindFailed(message) {
            this.spinner = false;
            toastr.error(message, 'Oops !');
        }
    }
}
</script>
<style lang="scss">
.service-list {
    list-style: none;
    width: 100%;
    padding-left: 0;
}
.service-list > li {
    cursor: pointer;
    padding: 10px 10px;
    width: 100%;
    font-size: 14px;
    font-weight: bold;
    border-bottom: 1px solid #E0E0E0;
}
.service-list > li > span {
    margin-left: 15px;
}
</style>
