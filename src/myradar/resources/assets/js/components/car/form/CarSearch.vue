<template lang="html">
  <div class="form-inline">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Type Registration No." v-model="reg"/>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Type Commercial ID" v-model="com"/>
    </div>
    <button class="btn btn-primary btn-sm" v-on:click="search">
      <i class="fa fa-search"></i> Search
    </button>
    <button class="btn btn-default btn-sm" v-show="showClearButton" v-on:click="clear">
      <i class="fa fa-times"></i> Clear
    </button>
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
            searchClicked: false,
        };
    },
    computed: {
        showClearButton: function() {
            return this.searchClicked || this.reg.length || this.com.length;
        }
    },
    mounted: function() {
        this.reg = this.content.reg;
        this.com = this.content.com;
    },
    methods: {
        search() {
            this.searchClicked = true;
            this.onSubmit(this.reg, this.com);
        },
        clear() {
            this.reg = '';
            this.com = '';
            if (this.searchClicked == true) {
                this.onSubmit(this.reg, this.com);
            }
            this.searchClicked = false;
        }
    }
}
</script>

<style lang="css">
</style>
