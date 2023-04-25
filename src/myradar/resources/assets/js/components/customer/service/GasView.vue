<template>
  <div class="col-xs-12 col-md-6">
    <div class="info-boxx large-box">
      <div class="col-xs-12" style="padding-top: 10px;">
        <span class="box-title">GAS HISTORY</span>
      </div>
      <div class="col xs-12">
        <div class="content" v-show="subscribed">
          <div class="refill-history">
            <div
              style="padding: 8px 12px;"
              v-for="(event, i) in refillHistory"
              :key="i"
            >
              <span style="color: #424242; font-weight: 700; font-size: 13px;">{{ event.body }}</span>
              <br>
              <small style="color: #757575; font-weight: 500">{{ event.time }}</small>
            </div>
          </div>
        </div>
        <div class="content" v-show="!subscribed">
          <not-subscribed
            body="Not subscribed"
            :extra-height="true"
          ></not-subscribed>
        </div>
      </div>
      <!-- <div class="col-xs-3 col-md-3 col-lg-3" v-show="subscribed">
        <button v-on:click="show()" type="button" name="button" data-toggle="modal" data-target="#myModal" class="btn btn-success refill-historybtn">Refill History</button>
      </div> -->

      <!-- <div class="col-xs-3 col-md-3 col-lg-3">
        <div class="select-style pull-right" v-show="subscribed">
          <select v-model="days">
            <option value="5">Last 5 Days</option>
            <option value="10">Last 10 Days</option>
            <option value="15">Last 15 Days</option>
          </select>
        </div>
      </div> -->
      <!-- <div class="content table-responsive" v-show="subscribed">
        <spinner v-show="loading" :extra-height="false"></spinner>
        <table class="gas-view" v-show="!loading && !empty">
          <tbody>
            <tr v-for="n in 5">
              <td v-for="v in values">
                <div class="cell" :class="getCellClass(5 - n, v)"></div>
              </td>
            </tr>
            <tr>
              <td v-for="v in values">
                <span class="date-label">{{v.when}}</span>
              </td>
            </tr>
          </tbody>
        </table>
        <no-data v-show="!loading && empty"></no-data>
      </div> -->

      <!--modal starts herer-->
      <!-- <modal name="gas-refill-historymodal" :scrollable="true" height="auto">
        <div class="modal-box">
          <div class="col-xs-12 col-md-12 col-lg-12 modaltopbar">
            <div class="col-xs-6 col-md-6 col-lg-6 modal-titlecontainer">
              <span class="modal-title"
                >Gas Refill History For Car {{ this.regNo }}</span
              >
            </div>
            <div class="col-xs-6 col-md-6 col-lg-6 close-buttoncontainer">
              <i class="fa fa-times close-btn" v-on:click="hide()"></i>
            </div>
          </div>

          <div
            class="col-xs-12 col-md-12 col-lg-12 historyvalue"
            v-for="(item, i) in modalvalue"
            v-bind:class="isodd(i)"
          >
            <div class="col-xs-1 col-md-1 col-lg-1 slno">{{ i + 1 }}.</div>
            <div class="col-xs-11 col-md-11 col-lg-11 databody">
              <div class="data">{{ item.body }}</div>
              <div class="subdata">{{ item.time }}</div>
            </div>
          </div>
        </div>
      </modal> -->
    </div>
  </div>
</template>
<script>
import EventBus from '../../../util/EventBus'
import GasApi from '../../../api/GasApi'
import EventApi from '../../../api/EventApi'

import NotSubscribed from '../../util/NotSubscribed.vue'
import NoData from '../../util/NoItemFound.vue'
import Spinner from '../../util/Spinner'
import Vue from 'vue'
import VModal from 'vue-js-modal'

Vue.use(VModal)

export default {
  props: ['deviceId', 'subscribed', 'regNo'],
  components: { Spinner, NoData, NotSubscribed },
  data: () => ({
    days: '5',
    values: [],
    empty: false,
    loading: true,
    modalvalue: [],
    refillHistory: [],
  }),
  watch: {
    days: function(newVal, oldVal) {
      this.getGasData(this.deviceId, newVal)
    },
    deviceId: function(newVal, oldVal) {
      this.getEventHistory(newVal)
    },
  },
  mounted() {
    EventBus.$on('gas-chart-found', this.onDataFound.bind(this))
    if (this.subscribed) {
      // this.getGasData(this.deviceId, this.days)
      this.getEventHistory(this.deviceId)
    }
  },
  methods: {
    isodd(i) {
      return i % 2 === 1 ? 'grayback' : 'whiteback'
    },
    show() {
      EventApi.recent(this.deviceId, 30, 3).then(
        list => (this.modalvalue = list)
      )

      this.$modal.show('gas-refill-historymodal')
    },
    hide() {
      this.$modal.hide('gas-refill-historymodal')
    },
    getGasData(id, days) {
      this.loading = true
      let api = new GasApi(EventBus)
      api.history(id, days)
    },
    getEventHistory(deviceId) {
      EventApi.recent(this.deviceId, 30, 3).then(list => {
        console.log(`refill history`, list.length)
        this.refillHistory = list
      })
    },
    onDataFound(list) {
      this.loading = false
      this.empty = !list.length
      this.values = list
    },
    getCellClass(row, val) {
      let size = this.values.length > 10 ? 'cell-sm' : 'cell'
      return size + ' ' + this.getCellColor(row, val)
    },
    getCellColor(row, val) {
      if (row == 0) {
        return 'yellow-cell'
      }

      return row <= val.value ? 'green-cell' : ''
    },
  },
}
</script>
<style lang="scss" scoped>
.refill-history {
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: stretch;
  max-height: 40vh;
  overflow: scroll;
}
.refill-history > div:nth-child(odd) {
  background-color: #eceff1;
}
.refill-history > div:nth-child(even) {
  background-color: white;
}
table > tbody > tr > td {
  border-right: 1px solid #e0e0e0;
}

.grayback {
  background-color: #e0e0e0;
}
.highlight {
  font-weight: bold;
  color: red;
}

.databody {
  padding: 0px;
}
.slno {
  padding: 0px;
  text-align: center;
}

.data {
  font-size: 16px;
}
.subdata {
  padding-left: 18px;
  font-size: 13px;
  color: #9e9e9e;
}
.modal-titlecontainer {
  padding: 0px;
}
.close-buttoncontainer {
  padding: 0px;
}
.modaltopbar {
  padding-top: 10px;
  border-bottom: 1px solid #e0e0e0;
  background-color: #039be5;
  padding-bottom: 10px;
}
.modal-title {
  font-weight: bold;
  color: #ffffff;
  font-size: 17px;
}
.historyvalue {
  padding: 10px;
  border-bottom: 1px solid #e0e0e0;
}
.close-btn {
  float: right;
  padding: 2px;
  padding-left: 10px;
  padding-right: 10px;
  color: #ffffff;
}
.refill-historybtn {
  padding-top: 5px;
  padding-bottom: 4px;
  padding-right: 6px;
  padding-left: 6px;
  margin-right: 2%;
  margin-top: 12%;
}
.gas-view {
  width: 100%;
  margin-top: 15px;
  border-left: 1px solid #e0e0e0;
  border-bottom: 1px solid #bdbdbd;
}
.date-label {
  width: 100%;
  text-align: center;
  display: block;
  margin: 2px auto;
  font-size: 14px;
  color: #757575;
}
.cell {
  width: 20px;
  height: 20px;
  display: block;
  margin: 5px auto;
}
.cell-sm {
  width: 15px;
  height: 15px;
  display: block;
  margin: 5px auto;
}
.green-cell {
  background: #4caf50;
}
.yellow-cell {
  background: #ffeb3b;
}
</style>
