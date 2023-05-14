<template>
    <!-- <div id=''>
      <item  v-for="(scheme, i) in promo_schemes" :scheme="scheme" :key="i" :serial="i + 1"> </item>
    </div> -->
    <div class="">
      <table class="table table-responsive customer-table" v-show="!noItem">
          <thead>
              <tr>
                  <th class="col-xs-1">#</th>
                  <th class="col-xs-2"><i class="fa fa-user-circle"></i> Code</th>
                  <th class="col-xs-7"><i class="fa fa-user"></i> Referrer</th>
                  <th class="col-xs-2"><i class="fa fa-car"></i> Used</th>
              </tr>
          </thead>
          <tbody>
              <!-- <customer v-for="(user, i) in users"
                :user="user"
                :index="serial(i)"
                :key="i">
              </customer> -->
              <promo-code v-for = "(promo, i) in promos"
                :promo="promo"
                :index="getSerialNo(i)"
                :key="i">
              </promo-code>
          </tbody>
      </table>

      <pagination v-bind:pagination="pagination"
                  v-on:click.native="onPageChanged(pagination.current_page)"
                  :offset="offset"
                  v-show="!noItem">
      </pagination>
    </div>

</template>
<script>
import PromotionApi from '../../../api/PromotionApi';
import EventBus from '../../../util/EventBus';
import Pagination from '../../util/Pagination.vue';
import Spinner from '../../util/Spinner.vue';
import NoItemFound from '../../util/NoItemFound.vue';
import PromoCode from './PromoCode';
export default {
  name: "",
  components: {
    PromoCode,
    Pagination,
    Spinner,
    NoItemFound,
  },
  data: () => ({
    promos: [],
    search: {
        reg: '',
        com: '',
        phone: '',
    },
    pagination: {
        total: 0,
        per_page: 15,
        total_pages: 0,
        current_page: 1,
    },
    offset: 4,

  }),
  computed:{
    // promo_schemes(){
    //   return this.schemes;
    // },
    noItem() {
        return this.promos.length == 0;
    }
  },
  mounted() {
    EventBus.$on('promo-code-list-found',this.onPromoCodeListFound.bind(this));
    let api= new PromotionApi(EventBus);
    api.promoCodeList(1);
  },
  methods: {
    onPromoCodeListFound(data) {

      this.promos = data.data;
      this.pagination.total_pages = data.last_page,
      this.pagination.current_page = data.current_page,
      this.pagination.total = data.total,

      console.log(this.promos);
    },
    onPageChanged(page) {
      let api= new PromotionApi(EventBus);
      api.promoCodeList(page);
    },
    getSerialNo(i) {
      return (this.pagination.current_page - 1) * this.pagination.per_page + 1 + i;
    },
  }
}
</script>

<style lang="scss" scoped>

</style>
