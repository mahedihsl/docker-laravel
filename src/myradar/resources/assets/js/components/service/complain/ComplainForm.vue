<template>
  <div id="">
    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Compose New Complain</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
              <input  v-model="title" class="form-control" placeholder="Headline">
          </div>
          <div class="form-group">
            <textarea  v-model="body" placeholder="Describe the problem" id="compose-textarea" class="form-control" style="height: 200px;"> </textarea>
          </div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Employee</label>
							<select v-model="selectedEmp" class="form-control">
								<option v-for="(e, i) in employees" :key="i">{{ e }}</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Complain Type</label>
							<select v-model="selectedType" class="form-control">
								<option v-for="(t, i) in types" :key="i">{{ t }}</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Car Registration No.</label>
							<input  v-model="reg_no" class="form-control" placeholder="">
							<!-- reg_no__input -->
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Responsible Team ?</label>
							<select v-model="responsible" class="form-control">
								<option value="1">CCD</option>
								<option value="2">Eng - Ops</option>
							</select>
						</div>
					</div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="pull-right">
            <button @click="changeView(0)" type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Cancel</button>
            <button @click="onSaveClick" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
          </div>

        </div>
            <!-- /.box-footer -->
      </div>
  </div>
</template>
<script>
import EventBus from '../../../util/EventBus';
import vSelect from "vue-select";
import store from '../../../service/complain/store';
export default {
  name: "",
  store,
  components: {
    vSelect,
  },
  data: () => ({
    employees: ['Wahida', 'Hasib', 'Masud', 'Agent 1', 'Agent 2', 'Rubel', 'Ahnaf', 'Shahadat'],
    types: ['Less Lat-Lng', 'Frequent Reset', 'Frequent Hang', 'Device Stopped', 'ES Missing', 'Notification', 'Gas Refill', 'Gas Meter', 'Lock-unlock', 'other'],
    selectedType: '',
    selectedEmp: '',
		responsible: '1',
    reg_no: null,
    title: "",
    body: "",
    status: "open",
    saving: false,
  }),
  computed:{

  },
  mounted() {
    this.selectedEmp = this.employees[0];
    this.selectedType = this.types[0];

    EventBus.$on('complain-save-finish', this.onSaveFinish.bind(this));
  },
  methods: {
    changeView(k) {
      EventBus.$emit('change-view',k);
      this.changeContent(k);
    },
    changeContent(k) {
      EventBus.$emit('change-content', k);
    },
    onSaveClick(){
      if(!this.title || !this.body || !this.reg_no || this.saving) return;

      let data = {
          title : this.title,
          body  : this.body,
          emp   : this.selectedEmp,
          status: this.status,
          type  : this.selectedType,
          reg_no: this.reg_no,
					responsible: this.responsible
      };

      this.saving = true;
      this.$store.dispatch('save',data);
    },
    onSaveFinish(body){
      if(body.status){
        this.$store.dispatch('getComplains',1);
        this.changeView(0);
        this.changeContent(0);
        toastr.success('Complain Saved Successfully');
      }
      else{
        toastr.error(body.data.message);
      }
      this.saving = false;
    }
  }
}
</script>
<style lang="scss" scoped>
.reg_no__input{
  height: 42px;
  border-radius: 4px 4px;
}
</style>
