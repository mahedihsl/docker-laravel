<template lang="html">
  <div class="form-inline">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Type Registration No." v-model="reg"/>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Type Commercial ID" v-model="com"/>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Type Phone Number" v-model="phone"/>
    </div>
    <button class="btn btn-primary btn-sm" v-on:click="search">
      <i class="fa fa-search"></i> Search
    </button>
    <button class="btn btn-default btn-sm" v-show="showClearButton" v-on:click="clear">
      <i class="fa fa-times"></i> Clear
    </button>
    <a class="btn btn-primary button-pill exportBtn" href="/vehicles/export">
      <i class="fa fa-file-excel-o" aria-hidden="true"></i>
      Export
    </a>
  </div>
</template>

<script>
export default {
    props: {
        onSubmit: Function,
        content: Object,
    },
    data: function() {
        return {
            reg: '',
            com: '',
            phone: '',
            searchClicked: false,
        };
    },
    computed: {
        showClearButton: function() {
            return this.searchClicked || this.reg.length || this.com.length || this.phone.length;
        }
    },
    mounted: function() {
        this.reg = this.content.reg;
        this.com = this.content.com;
        this.phone = this.content.phone;
    },
    methods: {
        search() {
            this.searchClicked = true;
            this.onSubmit(this.reg, this.com, this.phone);
        },
        clear() {
            this.reg = '';
            this.com = '';
            this.phone = '';
            if (this.searchClicked == true) {
                this.onSubmit(this.reg, this.com);
            }
            this.searchClicked = false;
        }
    }
}
</script>

<style lang="css">
.exportBtn{
  margin-left: 5px;
}
</style>
