<template>
  <div class="row">
      <div class="col-md-12">
        <div class="blank-panel">
          <h4 class="text-center text-grey">No Geofence Found</h4>
          <button class="btn btn-primary btn-shadow btn-big center-item mt-8" @click="$emit('create')">
            <i class="fa fa-plus"></i>
            Add Geofence
          </button>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  
}
</script>

<style scoped>
.blank-panel {
  background: #f5f5f5;
  border-radius: 8px;
  padding: 120px 0;
}
.center-item {
  margin-left: auto;
  margin-right: auto;
  display: block;
}
.mt-8 {
  margin-top: 2rem;
}
.btn-big {
  padding: 10px 25px;
}
.btn-shadow {
  border-radius: 4px;
  -webkit-box-shadow: 0px 10px 20px 0px rgba(201,201,201,1);
  -moz-box-shadow: 0px 10px 20px 0px rgba(201,201,201,1);
  box-shadow: 0px 10px 20px 0px rgba(201,201,201,1);
}
</style>