<template lang="html">
    <div class="form">
        <table class="table">
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>
                      <input id="name" name="name" placeholder="Name"
                        v-validate = "'required'"
                        :class="{'form-control':true,'is-danger': errors.has('name') }"
                        v-model="info.name">
                        <p class="help-block"></p>
                         <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span>
                    </td>
                </tr>
                <tr>
                    <td>Manufacturer</td>
                    <td>
                        <select class="form-control" name="maker" v-model="info.maker">
                            <option value="0">Select Manufacturer</option>
                            <option :value="m.id" v-for="m in makers">{{ m.name }}</option>
                        </select>
                          <p class="help-block">{{makerSelectionMsg}}</p>
                    </td>
                </tr>
                <tr>
                    <td>Model</td>
                    <td>
                      <input id="model" name="model" placeholder="Model Name"
                        v-validate = "'required'"
                        :class="{'form-control':true,'is-danger': errors.has('model') }"
                        v-model="info.model">
                        <p class="help-block"></p>
                         <span v-show="errors.has('model')" class="text-danger">{{ errors.first('model') }}</span>

                    </td>

                </tr>
                <tr>
                    <td>Reg no.</td>
                      <td>
                      <input id="reg_no" name="reg_no" placeholder="Reg No."
                        v-validate = "'required'"
                        :class="{'form-control':true,'is-danger': errors.has('reg_no') }"
                        v-model="info.reg_no">
                        <p class="help-block"></p>
                        <span v-show="errors.has('reg_no')" class="text-danger">{{ errors.first('reg_no') }}</span>
                    </td>


                </tr>
                <tr>
                    <td>Engine no.</td>
                    <td><input type="text" name="engine_no" class="form-control" v-model="info.engine_no" ></td>
                </tr>
                <tr>
                    <td>Chesis no.</td>
                    <td><input type="text" name="chesis_no" class="form-control" v-model="info.chesis_no"></td>
                </tr>

                <tr>
                    <td>Reg. date</td>
                    <td><input type="text" name="reg_date" class="form-control" data-toggle="datepicker" v-model="info.reg_date" ></td>
                </tr>
                <tr>
                    <td>Tax date</td>
                    <td><input type="text" name="tax_date" class="form-control" data-toggle="datepicker" v-model="info.tax_date"></td>
                </tr>
                <tr>
                    <td>Fitness date</td>
                    <td><input type="text" name="fitness_date" class="form-control" data-toggle="datepicker" v-model="info.fitness_date"></td>
                </tr>
                <tr>
                    <td>Insurance date</td>
                    <td><input type="text" name="insurance_date" class="form-control" data-toggle="datepicker" v-model="info.insurance_date"></td>
                </tr>

                <tr>
                    <td>Color</td>
                    <td>
                         <select class="form-control" name="color" v-model="info.color">
                            <option value="0">Select Color</option>
                            <option :value="c.id" v-for="c in colors">{{ c.name }}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td>
                        <select class="form-control" name="type" v-model="info.type">
                           <option value="0">Select Vehicle Type</option>
                            <option :value="t.id" v-for="t in types">{{ t.name }}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Fuel Type</td>
                    <td>
                        <select class="form-control" name="fuel" v-model="info.fuel">
                               <option value="0">Select Fuel Type</option>
                              <option :value="f.id" v-for="f in fuels">{{ f.name }}</option>
                        </select>
                          <span v-show="errors.has('fuel')">{{ errors.first('fuel') }}</span>
                    </td>
                </tr>
                <tr>
                    <td>Engine CC</td>
                    <td><input type="text" name="engine_cc" class="form-control" v-model="info.engine_cc"></td>
                </tr>
                <tr>
                    <td>Seat no.</td>
                    <td><input type="text" name="seat_count" class="form-control" v-model="info.seat_count"></td>
                </tr>
                <tr>
                    <td>CNG</td>
                    <td>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1" name="cng"  checked="" v-model="info.cng">
                            </label>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>Note</td>
                    <td><textarea name="note" rows="4" class="form-control" v-model="info.note"></textarea></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" :class="{'btn btn-success pull-right':true,'disabled': isButtonDisabled }"
         @click="next()">
            <i class="fa fa-arrow-right"></i> Next
        </button>
        <button type="button" class="btn btn-default pull-right" @click="back()">
            <i class="fa fa-arrow-left"></i> Back
        </button>

    </div>

</template>

<script>
import '@fengyuanchen/datepicker';
import customRule from '../../../Rule.js';



export default {
    data: function() {
        return {
            title: 'New Vehicle',
            makers: [],
            colors :[],
            fuels :[],
            types :[],
            makerSelectionMsg:'',
            info: {
                name: '',
                maker: '0',
                model : '',
                reg_no:'',
                engine_no:'',
                chesis_no:'',
                reg_date: '',
                tax_date:'',
                fitness_date:'',
                insurance_date:'',
                color:'0',
                type:'0',
                fuel:'0',
                engine_cc:'',
                seat_count:'',
                cng:'',
                note:''
            },
        };
    },

    computed: {
        types() { return this.$store.getters.carTypes(); },
        isButtonDisabled() {
          return !this.isMakerSelected ||this.errors.any()
        },
        isMakerSelected(){
           return parseInt(this.info.maker)!=0;

        }
    },
    watch: {

    },
    mounted: function() {
        $('[data-toggle="datepicker"]').datepicker();

        const vm = this;
        $('input[name="reg_date"]').change(function() {
            vm.info.reg_date = $(this).val();
        });
        $('input[name="tax_date"]').change(function() {
            vm.info.tax_date = $(this).val();
        });
        $('input[name="insurance_date"]').change(function() {
            vm.info.insurance_date = $(this).val();
        });
        $('input[name="fitness_date"]').change(function() {
            vm.info.fitness_date = $(this).val();
        });

        this.$store.commit('setPageTitle', this.title);

        this.$http.get('/car/makers/api').then(response => {
            this.makers = response.body;
        }, error => {});

        this.$http.get('/car/colors/api').then(response => {
            this.colors = response.body;
        }, error => {});

        this.$http.get('/car/type/api').then(response => {
            this.types = response.body;
        }, error => {});

        this.$http.get('/car/fuel/api').then(response => {
            this.fuels = response.body;
        }, error => {});
    },
    methods: {
            next() {
              $("#name").focus();
              $("#model").focus();
              $("#reg_no").focus();

              if(!this.isMakerSelected)
               {
                 console.log("am");
                 this.makerSelectionMsg = 'Please Select Maker';
               }
               else{
                 this.makerSelectionMsg="";

               }
              if(this.isButtonDisabled==true)
                {
                  return
                }
                for (let k in this.info) {
                    console.log('key: ' + k);
                    if (this.info.hasOwnProperty(k)) {
                        this.$store.commit('updateCarInfo', {key: k, val: this.info[k]});
                    }
                }

                this.$emit('next');

            },

        back() {
            this.$emit('back');
        },

    }
}
</script>

<style lang="css">
</style>
