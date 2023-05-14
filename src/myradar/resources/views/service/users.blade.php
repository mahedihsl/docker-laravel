@extends('layouts.app')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
   integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
   crossorigin="anonymous"></script>
<script src="{{ asset('js/moment.min.js') }}" charset="utf-8"></script>
<style>


</style>
@section('content')
<div class="container">
<div class="row">
   <div class="col-md-11 col-md-offset-1">
      <div class="panel panel-default">
         <div class="panel-heading">Service Diagnosis</div>
         <br>

         <form>
            <div class="row">
               <div class="col-sm-2 col-sm-offset-1">
                  <div class="form-group">
                     <input type="text" name="name" id="name" class="form-control" placeholder="Customer Name" value="{{$user_name or ''}}">

                     <p class="help-block"></p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <input type="text" name="phone" id ="phone" class="form-control" placeholder="Phone" value="{{$user_phone or ''}}">
                     <p class="help-block"></p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <input type="text" name="reg" id="reg" class="form-control" placeholder="Reg. no" value="{{$car_reg_no or ''}}">
                     <p class="help-block"></p>
                  </div>
               </div>
               <div class="col-sm-2">
                  <button class="btn btn-primary btn-sm"  type="submit">
                  Search
                </div>
                <a href="/service/serviceLog"><i class="fa fa-refresh fa-2x"></i>

            </div>
      </div>
      </form>
      @if(isset($users))
      {{ $users->appends(request()->input())->links()}}
      @endif
      <table  id="myTable" class="table table-striped table-bordered table-hover table-responsive">
         <thead>
            <th>Name</th>
            <th>Phone</th>
            <th>Car Reg No.</th>
            <th>Diagnosis</th>
         </thead>
         <tbody>
            @if(!empty($users))
            @foreach ($users as $car)
                @if ($car->user)
                    <tr>
                       <td>{{ $car->user->name }}</td>
                       <td>{{ $car->user->phone }}</td>
                       <td>{{ $car->reg_no }}</td>
                       <td><a class="btn btn-default" href="/service/showServiceLog/{{$car->user->id}}"><i class="fa fa-eye fa-1x"></i></a></td>
                    </tr>
                @endif
            @endforeach
            @endif
         </tbody>
      </table>
   </div>
</div>
@endsection

<script>





</script>


@section('js')
@endsection
