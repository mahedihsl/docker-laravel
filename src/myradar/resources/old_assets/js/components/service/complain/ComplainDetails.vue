<template>
  <div id="">
    <div class="box box-default details">
      <div class="box-header with-border">
        <div class="row">
          <div class="bar col-md-2">
            <select class="form-control" v-model="status">
              <option v-for="(s, i) in statusList" :key="i" :value="s">
                {{ s }}
              </option>
            </select>
          </div>
          <div class="bar col-md-2">
            <select v-model="responsible" class="form-control">
              <option value="0">N/A</option>
              <option value="1">CCD</option>
              <option value="2">Eng - Ops</option>
            </select>
          </div>
          <div class="bar col-md-2">
            <p>
              Token: <b>{{ complain.token }}</b>
            </p>
          </div>
          <div class="bar col-md-2">
            <p>
              <a :href="car_url">
                Reg no: <b>{{ complain.reg_no }}</b>
              </a>
            </p>
          </div>
          <div class="col-md-2">
            <div class="back-btn">
              <button @click="onBackClick" class="btn btn-default" type="button" name="button">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
              </button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="bar col-md-2">
            <label>Complain Type</label>
            <select v-model="type" class="form-control">
              <option v-for="(t, i) in types" :value="t" :key="i">
                {{ t }}
              </option>
            </select>
          </div>
          <div class="bar col-md-3">
            <p>
              Name: <b>{{ complain.user }}</b>
            </p>
          </div>
          <div class="bar col-md-2">
            <p>
              Emp: <b>{{ complain.emp }}</b>
            </p>
          </div>
          <div class="bar col-md-3">
            <p>
              Date: <b>{{ complain.date }}</b>
            </p>
          </div>
        </div>

        <div
          v-if="status === 'closed'"
          class="tw-w-full tw-flex tw-flex-col tw-border tw-border-solid tw-border-gray-300 tw-rounded-lg tw-px-10 tw-py-4 tw-mt-6"
        >
          <span class="tw-text-gray-700 tw-text-2xl tw-font-medium">Select Customer Review/Feedback</span>
          <div class="tw-w-full tw-mt-3 tw-flex tw-flex-row tw-flex-wrap tw-space-x-4">
            <label v-for="(rv, i) in reviews" :key="i">
              <input type="radio" name="review" v-model="review" :value="rv.tag" class="tw-peer tw-sr-only" />
              <span
                class="tw-px-4 tw-py-2 tw-rounded tw-border tw-border-solid tw-border-gray-200 tw-text-gray-700 tw-text-xl tw-font-normal tw-bg-white hover:tw-bg-gray-100 peer-checked:tw-bg-green-500 peer-checked:tw-text-white peer-checked:tw-border-green-700 tw-transition tw-duration-300 tw-cursor-pointer"
              >
                {{ rv.label }}
              </span>
            </label>
          </div>
        </div>
      </div>
      <div class="box-body no-padding">
        <div class="complain complain-title">
          <h3>{{ complain.title }}</h3>
        </div>
        <hr />
        <div class="paragraph-title">
          <h4>description</h4>
        </div>
        <div class="complain complain-body">
          <p>{{ complain.body }}</p>
        </div>
        <hr />
        <div class="paragraph-title">
          <h4>Comment</h4>
        </div>
        <div class="form-group comment-box">
          <textarea v-model="comment" placeholder="please add some comment" class="form-control" style="height: 100px">
          </textarea>
          <button @click="onCommentClick" class="btn btn-default pull-right" type="button" name="button">
            Save
          </button>
        </div>
        <div class="comment">
          <p v-for="(com, i) in complain.comment" :key="i">
            <strong>Time: {{ com.when }}</strong
            ><br />
            <strong>{{ com.who }} - </strong>{{ com.body }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
import store from '../../../service/complain/store'
import EventBus from '../../../util/EventBus'
export default {
  name: '',
  store,
  components: {},
  data: () => ({
    comment: '',
    statusList: ['open', 'investigating', 'resolved', 'replace', 'closed', 'reopen'],
    status: '',
    reviews: [
      { tag: 'best', label: 'Excellent' },
      { tag: 'good', label: 'Good' },
      { tag: 'bad', label: 'Not Satisfactory' },
    ],
    review: '',
    responsible: '1',

    types: [
      'Less Lat-Lng',
      'Frequent Reset',
      'Frequent Hang',
      'Device Stopped',
      'ES Missing',
      'Notification',
      'Gas Refill',
      'Gas Meter',
      'Lock-unlock',
      'other',
    ],
    type: '',
  }),
  computed: {
    ...mapGetters({
      complain: 'selectedComplain',
      pagination: 'pagination',
    }),
    car_url() {
      return '/manage/customer/' + this.complain.ids.user + '?tab=vehicles&target=' + this.complain.ids.car
    },
  },
  mounted() {
    EventBus.$on('comment-add-finish', this.onCommentAddFinish.bind(this))
    this.type = this.complain.type
    this.status = this.complain.status
    this.review = this.complain.review
    this.responsible = this.complain.responsible
  },
  methods: {
    onBackClick() {
      this.$store.commit('changeContent', 0)
    },
    onCommentClick() {
      if (this.status === 'closed' && !this.review) {
        alert('Please select a customer review')
        return
      }
      this.$store.dispatch('addComment', {
        comment: this.comment,
        type: this.type,
        status: this.status,
        review: this.review,
        responsible: this.responsible,
      })
    },
    onCommentAddFinish(body) {
      if (body.status) {
        toastr.success('Data saved Successfully')
        this.$store.dispatch('getComplains', this.pagination.current_page)
        this.comment = ''
      } else {
        toastr.error(body.data.message)
      }
    },
  },
}
</script>
<style lang="scss" scoped>
.details {
}
.complain {
  background: #fff;
  border-radius: 4px;
  padding: 10px;
}
.complain-title {
  margin: 8px 0;
  //border-left: 3px solid #BC1F18;
}
.complain-title h3 {
  margin: 5px 0;
  color: #242729;
}
.complain-body,
.comment-box {
  margin: 10px 0px;
  font-size: 18px;
  color: #525252;
}
.comment {
  margin: 10px 8px;
  font-size: 15px;
  background: #fff;
  border-radius: 4px;
  padding: 5px;
  color: #525252;
}
.comment-box button {
  margin: 8px 0;
}
.complain-title,
.complain-body,
.comment,
.bar {
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.16);
}
.bar {
  margin-right: 8px;
  margin-bottom: 2px;
  padding: 0;
  border-radius: 4px;
  text-align: center;
  vertical-align: middle;
  //border-top: 1px solid #BC1F18;
}

.bar p {
  margin: 11px 0;
  font-size: 14px;
  color: #546e7a;
}

.back-btn {
  padding: 8px;
}

.paragraph-title {
  margin-bottom: 0px;
  margin-top: 20px;
}
.row {
  margin-left: 3px;
}
</style>
