<template lang="html">
    <div class="form">
        <div class="form-group form-group-lg">
            <h4>Commercial ID</h4>
            <input type="text" v-model="commercialId"   v-validate = "'required|numeric'" name="commercialId" class="form-control" placeholder="Type Commercial ID">
                <span v-show="errors.has('commercialId')" class="help is-danger">{{ errors.first('commercialId') }}</span>
        </div>
        <hr>
        <h4>Services</h4>
        <!-- List group -->
        <ul class="list-group">
            <li class="list-group-item" v-for="serv in services">
                {{ serv.name }} - <strong>{{ serv.type }}</strong>
                <div class="material-switch pull-right">
                    <input v-bind:id="serv.id" type="checkbox" @click="toggleService(serv.sid)"
                       v-validate ="{ rules: { required: this.isRequired} }"/>

                    <label v-bind:for="serv.id" class="label-primary"></label>
                </div>
            </li>
        </ul>
        <button type="button" :class="{'btn btn-success pull-right':true,'disabled': isButtonDisabled }"
         @click="submitForm()">
            <i class="fa fa-save"></i> Save
        </button>
        <button type="button" class="btn btn-default pull-right" @click="goBack()">
            <i class="fa fa-arrow-left"></i> Back
        </button>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
  data: function() {
    return {
      title: 'Add Services',
      commercialId: '',
      services: [],
      selected: []
    };
  },
  components: {
    // NewCustomer,NewCar
  },
  computed:{

  isRequired(){
       return console.log(this.value)

  },
  isButtonDisabled() {
    return this.errors.any()

  }
  },
  methods: {
    toggleService(id) {
      let exists = _.find(this.selected, (o) => o == id);
      if (exists != undefined) {
        _.remove(this.selected, (n) => n == id);
      } else {
        this.selected.push(id);
      }
    },
    goBack() {
      this.$emit('back');
    },
    submitForm() {

      this.$store.commit('updateSelectedServices', this.selected);
      this.$store.commit('updateCommercialId', this.commercialId);
      if(this.isButtonDisabled==true)
        {
          return
        }
      this.$store.dispatch('saveForm');

      this.$emit('next');
    },
    goNext() {

      this.$emit('next');
    }
  },
  mounted: function() {
    this.$store.commit('setPageTitle', this.title);
    this.$http.get('/services/api').then(response => {
      this.services = response.body;
    }, error => {});
  }
}
</script>

<style lang="css">
.material-switch > input[type="checkbox"] {
    display: none;
}

.material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative;
    width: 40px;
}

.material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}
.material-switch > label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}
.material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
}
.material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit;
    left: 20px;
}

</style>
