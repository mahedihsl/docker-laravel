<template>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4 col-md-offset-2">
                <h1 class="com_id" id="comid"
                :data-clipboard-text="comId"
                data-tippy-trigger="click"
                data-tippy-size="large"
                data-tippy-placement="top"
                data-tippy-animation="shift-away"
                data-tippy-arrow="true"
                title="Copied To Clipboard">{{comId}}</h1>
            </div>

            <div class="col-md-4">
                <button class="button button-raised button-pill button-royal com_button" @click="onGenerateClick">
                    <i class="fa fa-refresh fa-spin" v-show="spin1"></i>
                    New Commercial ID
                </button>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Phone Number" v-model="phone" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Version" v-model="version" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="IMEI Number" v-model="imei">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <button class="button button-pill button-action" @click="onSaveClick">
                    <i class="fa fa-check" v-show="!spin2"></i>
                    <i class="fa fa-refresh fa-spin" v-show="spin2"></i>
                    DONE
                </button>
                <a href="/devices/print/recent" target="_blank" class="button button-pill" style="margin-left: 15px;">
                    <i class="fa fa-print"></i>
                    Print
                </a>
                <a class="btn btn-primary button-pill exportBtn" href="/devices/export">
                  <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                  Export All
                </a>
            </div>
        </div>
    </div>
</template>
<script>
import EventBus from '../../util/EventBus';
import Api from '../../api/DeviceApi';

export default {
    data: () => ({
        spin1: false,
        spin2: false,
        comId: '',
        phone: '',
        version: '',
        imei: '',
    }),
    mounted() {
        EventBus.$on('com-id-found', this.onComIdFound.bind(this));
        EventBus.$on('device-create-ok', this.onDeviceCreateSuccess.bind(this));
        EventBus.$on('device-create-error', this.onDeviceCreateError.bind(this));

        new Clipboard('#comid');
        tippy('#comid');
    },
    methods: {
        onGenerateClick() {
            this.spin1 = true;
            let api = new Api(EventBus);
            api.generateNewId();
        },

        onSaveClick() {
            let error = this.validate();
            if (error) return;

            this.spin2 = true;
            this.error = '';
            let api = new Api(EventBus);
            api.create(this.comId, this.phone, this.version, this.imei);
        },

        validate() {
            let msg = '';

            if (!this.comId) msg += '<br>Commercial id is empty';
            if (!this.phone) msg += '<br>Phone number is empty';
            if(!this.version) msg+= '<br>Version is empty';

            if (msg) {
              $.alert({
                  title: 'Error !',
                  content: msg,
                  type: 'red',
                  theme: 'material',
              });

              return  true;
            }

            return false;
        },

        onComIdFound(id) {
            this.comId = id;
            this.spin1 = false;
        },

        onDeviceCreateSuccess(data) {
            this.spin2 = false;
            this.comId = '';
            this.phone = '';
            this.error = '';
            this.version = '';
            this.imei = '';

            toastr.success('Device successfully created !');

            EventBus.$emit('device-item-found', data);
        },

        onDeviceCreateError(message) {
            this.spin2 = false;
            $.alert({
              title: 'Error !',
              content: message,
              type: 'red',
              theme: 'material',
            });
        },

        onPrintClick() {
            EventBus.$emit('print-codes', 10);
        },
    }
}
</script>
<style lang="scss" scoped>
.com_button {
    margin-top: 20px;
}

.com_id {
    cursor: pointer;
    width: 100%;
    min-height: 60px;
    padding: 10px 15px;
    border-radius: 4px;
    text-align: center;
    background: #E0E0E0;
}
.exportBtn{
  padding-left:15px;
  padding-right:15px;
  padding-top:5px;
  padding-bottom: 5px;
  margin-left: 15px;
}
</style>
