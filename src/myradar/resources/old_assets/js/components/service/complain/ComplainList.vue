<template>
  <div id="">
    <div class="box box-primary">
      <div class="box-header with-border">
        <div class="row">
          <div class="col-md-3">
            <input
              type="text"
              class="form-control"
              placeholder="Type Name"
              v-model="name"
            />
          </div>
          <div class="col-md-3">
            <input
              type="text"
              class="form-control"
              placeholder="Type Token"
              v-model="token"
            />
          </div>
          <div class="col-md-3">
            <input
              type="text"
              class="form-control"
              placeholder="Car Reg. Number"
              v-model="reg_no"
            />
          </div>
          <div class="col-md-3">
            <button class="btn btn-primary btn-sm" v-on:click="search">
              <i class="fa fa-search"></i> Search
            </button>
            <a href="/complain/export" class="btn btn-defaul btn-sm">
              <i class="fa fa-file-text-o"></i> Export
            </a>
          </div>
          <!-- <button class="btn btn-default btn-sm" v-show="showClearButton" v-on:click="clear"><i class="fa fa-times"></i> Clear</button> -->
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="table-responsive mailbox-messages">
          <table class="table">
            <thead>
              <tr>
                <th class="col-md-1">#</th>
                <th class="col-md-1">Status</th>
                <th class="col-md-1">Responsible</th>
                <th class="col-md-1">Token</th>
                <th class="col-md-2">Car</th>
                <th class="col-md-3">Complainer</th>
                <th class="col-md-1">Creator</th>
                <th class="col-md-2">When</th>
              </tr>
            </thead>
            <tbody>
              <tr
                @click="onComplainClick(complain)"
                class="complain-row"
                v-for="(complain, i) in complains"
                :key="complain.key"
              >
                <td>{{ getSerialNo(i) }}</td>
                <td :class="complain.status">{{ complain.status }}</td>
                <td>{{ responsibleTeam(complain.responsible) }}</td>
                <td>{{ complain.token }}</td>
                <td>{{ complain.reg_no }}</td>
                <td>{{ complain.user }}</td>
                <td>{{ complain.emp }}</td>
                <td>{{ complain.when }}</td>
              </tr>
            </tbody>
          </table>
          <!-- /.table -->
          <pagination
            :pagination="pagination"
            @pageChanged="onPageChanged"
            :offset="offset"
            v-show="!noItem"
          >
          </pagination>
        </div>
        <!-- /.mail-box-messages -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /. box -->
  </div>
</template>
<script>
import Url from '../../../util/Url'
import store from '../../../service/complain/store'
import { mapGetters, mapMutations } from 'vuex'
import pagination from '../../util/Pagination.vue'
import EventBus from '../../../util/EventBus'
export default {
  name: '',
  store,
  components: {
    pagination,
  },
  data: () => ({
    user_id: '',
    name: '',
    token: '',
    reg_no: '',
  }),
  computed: {
    ...mapGetters({
      complainList: 'complainList',
      pagination: 'pagination',
      offset: 'offset',
    }),
    complains() {
      return this.complainList
    },
    noItem() {
      return this.complainList.length == 0
    },
  },
  mounted() {
    let url = new Url()
    this.user_id = url.getParameterByName('user_id') || ''
    this.$store.dispatch('getComplains', { page: 1, user_id: this.user_id })
  },
  methods: {
    ...mapMutations(['selectedComplain']),
    onComplainClick(complain) {
      this.$store.commit('selectedComplain', complain)
      this.$store.commit('changeContent', 1)
    },
    onPageChanged(page) {
      this.$store.dispatch('getComplains', {page, user_id: this.user_id})
    },
    getSerialNo(i) {
      return (
        (this.pagination.current_page - 1) * this.pagination.per_page + 1 + i
      )
    },
    search() {
      let params = {
        name: this.name,
        reg_no: this.reg_no,
        token: this.token,
      }
      this.$store.dispatch('search', params)
    },
    responsibleTeam(val) {
      var types = ['N/A', 'CCD', 'Eng - Ops']
      return types[parseInt(val)]
    },
    // color(complain) {
    //   if (complain.status == 'open') {
    //     return 'open';
    //   } else if (complain.status == 'investigating') {
    //     return 'investigating';
    //   } else if (complain.status == 'resolved') {
    //     return 'resolved';
    //   }
    // 	else if (complain.status == 'resolved') {
    // 	 return 'resolved';
    //  }
    //   return 'closed';
    // }
  },
}
</script>
<style lang="scss" scoped>
table {
  box-sizing: border-box;
}
td,
th {
  min-width: 50px;
}
td,
th {
  padding-left: 16px;
  min-width: 50px;
  border: 1px solid #e8e8e8;
  border-bottom: none;
  font: 14px/40px;
  text-align: left;
}
tr:hover {
  background-color: #fbfbfb;
  box-shadow: 0px 2px 18px 0px rgba(0, 0, 0, 0.5);
  cursor: pointer;
}
.form-group input {
  margin-right: 10px;
  border-radius: 4px;
}

.open {
  color: #c62828;
  font-weight: bold;
}
.investigating {
  color: #0277bd;
  font-weight: bold;
}
.resolved {
  color: #4527a0;
  font-weight: bold;
}
.replace {
  color: #ff01fb;
  font-weight: bold;
}
.reopen {
  color: #ba1200;
  font-weight: bold;
}
.closed {
  color: #2e7d32;
  font-weight: bold;
}
</style>
