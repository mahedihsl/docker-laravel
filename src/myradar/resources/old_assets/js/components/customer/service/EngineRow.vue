<template>
  <div id="" class="enginerow">

      <div class="col-xs-12 col-md-12 col-lg-12 databody" v-show="!on">

        <div class="col-xs-1 col-md-1 col-lg-1 slno">{{index+1}}.</div>
        <div class="col-xs-11 col-md-11 col-lg-11">
          <div class="data" v-html="$options.filters.highlight(item.body, 'off', item.type)">{{ item.body }}</div>
          <div class="subdata">{{item.time}}</div>
        </div>
      </div>

      <div class="col-xs-12 col-md-12 col-lg-12 databody" v-show="on">
        <div class="col-xs-1 col-md-1 col-lg-1 slno">{{index+1}}.</div>
        <div class="col-xs-11 col-md-11 col-lg-11">
          <div class="data" v-html="$options.filters.highlight(item.body, 'on', item.type)">{{ item.body }}</div>
          <div class="subdata">{{item.time}}</div>
        </div>
      </div>
  </div>
</template>
<script>
export default {
  props:['item','index'],
  name: "",
  data: () => ({
    odd:0,
  }),
  computed:{
    on(){
      return this.item.type == 1;
    }
  },
  methods:{

  },
  filters:{
    highlight: function(words, query, type){
      //console.log(this.item.type);
      if(type == 1)
        return words.replace(query,'<strong class="onColor">' + query.toUpperCase() + '</strong>');

      return  words.replace(query,'<strong class="offColor">' + query.toUpperCase() + '</strong>');
    },

  }
//{{item.body | highlight('gas')}}
}
</script>
<style lang="scss">
.offColor{
  color: #BF360C;
}

.onColor{
  color: #1B5E20;
}
</style>
