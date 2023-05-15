<template>
  <div id="">
    <button @click="changeView(1)" type="button" class="btn btn-primary btn-block margin-bottom" name="button">Compose</button>
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Folders</h3>

        <div class="box-tools">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body no-padding" style="">
        <ul class="nav nav-pills nav-stacked">
          <li class="active" @click="changeView(0)">
						<a href="#"><i class="fa fa-inbox"></i> All Complaiins</a>
					</li>
					<li>
						<a href="#"><span class="text-primary">Investigating</span> <span class="badge pull-right">{{count.inv}}</span></a>
					</li>
					<li>
						<a href="#"><span class="text-primary">Replace</span> <span class="badge pull-right">{{count.rep}}</span></a>
					</li>
					<li>
						<a href="#"><span class="text-danger">Open</span> <span class="badge pull-right">{{count.opn}}</span></a>
					</li>
					<li>
						<a href="#"><span class="text-success">Closed</span> <span class="badge pull-right">{{count.cls}}</span></a>
					</li>
					<li>
						<a href="#"><span class="text-primary">Re-Open</span> <span class="badge pull-right">{{count.reo}}</span></a>
					</li>
					<li>
						<a href="#"><span class="text-warning">Resolved</span> <span class="badge pull-right">{{count.rsl}}</span></a>
					</li>
        </ul>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /. box -->
    <!-- <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Labels</h3>

        <div class="box-tools">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>

    </div> -->
    <!-- /.box -->
  </div>
</template>
<script>
import EventBus from '../../../util/EventBus';
import store from '../../../service/complain/store';

export default {
  name: "",
  store,
  data: () => ({
		count: {
			inv: 0,
			opn: 0,
			cls: 0,
			rsl: 0,
			rep: 0,
			reo: 0,
		}
  }),
  computed:{

  },
  mounted() {
    //do something after mounting vue instance
		this.count.inv = $('input[name="count_inv"]').val();
		this.count.opn = $('input[name="count_opn"]').val();
		this.count.cls = $('input[name="count_cls"]').val();
		this.count.rsl = $('input[name="count_rsl"]').val();
		this.count.rep = $('input[name="count_rep"]').val();
		this.count.reo = $('input[name="count_reo"]').val();
  },
  methods:{
    changeView(k){
      this.$store.dispatch('getComplains',1);
      EventBus.$emit('change-view',k);
      this.changeContent(k);
    },
    changeContent(k){
      EventBus.$emit('change-content',k);
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
