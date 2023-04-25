<template>
  <div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-md-2 col-md-offset-5">
      <div class="form">
        <div class="form-group">
          <label>Switch Car</label>
          <select class="form-control" v-model="selected">
            <option v-for="(c, i) in cars" v-bind:value="c">{{c.name}}</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import EventBus from '../../../util/EventBus';
import CustomerApi from '../../../api/CustomerApi';

export default {
  props: ['userId'],
  data: () => ({
    selected: null,
    cars: [],
  }),
  mounted() {
    EventBus.$on('car-names-found', this.onCarListFound.bind(this));

    let api = new CustomerApi(EventBus);
    api.cars(this.userId);
  },
  watch: {
    selected: (newVal, oldVal) => {
      EventBus.$emit('car-switched', newVal);
    }
  },
  methods: {
    onCarListFound(list) {
      if (list.length) {
        this.cars = list;
        this.selected = list[0];
      } else {
        EventBus.$emit('car-list-empty');
      }
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
