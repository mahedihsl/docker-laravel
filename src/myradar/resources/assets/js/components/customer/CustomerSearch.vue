<template lang="html">
    <div class="form-inline">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Type Name" v-model="name">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Type Phone Number" v-model="phone">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Car Reg. Number" v-model="reg_no">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="User Ref. Number" v-model="ref_no">
        </div>
        <button class="btn btn-primary btn-sm" v-on:click="search"><i class="fa fa-search"></i> Search</button>
        <button class="btn btn-default btn-sm" v-show="showClearButton" v-on:click="clear"><i class="fa fa-times"></i> Clear</button>
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
            name: '',
            phone: '',
            reg_no: '',
            ref_no:'',
            searchClicked: false,
        };
    },
    computed: {
        showClearButton: function() {
            return this.searchClicked || this.name.length || this.phone.length;
        }
    },
    mounted: function() {
        this.name = this.content.name;
        this.phone = this.content.phone;
    },
    methods: {
        search() {
            this.searchClicked = true;
            this.onSubmit({
              name: this.name,
              phone: this.phone,
              reg_no: this.reg_no,
              ref_no: this.ref_no,
            });
        },
        clear() {
            this.name = '';
            this.phone = '';
            if (this.searchClicked == true) {
                this.onSubmit({
                  name: this.name,
                  phone: this.phone,
                  reg_no: this.reg_no,
                  ref_no: this.ref_no,
                });
            }
            this.searchClicked = false;
        }
    }
}
</script>

<style lang="css">
</style>
