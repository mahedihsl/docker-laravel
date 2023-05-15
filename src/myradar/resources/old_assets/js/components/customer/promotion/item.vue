<template>
  <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
    <div class="card ">
      <div class="card-title top">
        <i class="fa fa-tag" aria-hidden="true"></i>
        <h4>{{scheme.name}}</h4>
      </div>
      <div class="card-content">

        <h4><span class="bold">{{scheme.free_month}}</span> month free</h4>
        <h4><span class="bold">{{scheme.discount}}</span> taka discount</h4>
        <h4>Valid till: {{scheme.valid_till}}</h4>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "",
  props: ['scheme', 'serial'],
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>
.bold{
  font-weight: bold;
}
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  transition: 0.3s;
}

.card:hover {
    box-shadow: 0 32px 64px 0 rgba(0,0,0,0.2);
}

.card {
  margin-top: 5px;
  margin-bottom: 5px;
  box-sizing: border-box;
  border-radius: 2px;
  background-clip: padding-box;
  width: 100%;
  text-align: center;
}
.card span.card-title {
    color: #fff;
    font-size: 24px;
    font-weight: 300;
    text-transform: uppercase;
}

.card .card-image {
  position: relative;
  overflow: hidden;
}
.card .card-image img {
  border-radius: 2px 2px 0 0;
  background-clip: padding-box;
  background-position: center;
  position:relative;
  z-index: -1;
  width: 100%;
}
.card .card-image span.card-title {
  position: absolute;
  bottom: 0;
  left: 0;
  padding: 16px;
}
.card  .top{
  padding: 16px;
  border-radius: 0 0 2px 2px;
  background-clip: padding-box;
  box-sizing: border-box;

  font-size: 40px;
  color:#ffffff;
  background-color:#FF9800;
}
.top h4{
  font-size:20px;
}
.card .card-content {
  padding: 16px;
  border-radius: 0 0 2px 2px;
  background-clip: padding-box;
  box-sizing: border-box;
  width: 100%;
}

.card-content{
  height:85%;
}
.card .top p {
  color: #9E9E9E;
  font-size: 14px;
}
.card .card-content span.card-title {
  line-height: 48px;
}
</style>
