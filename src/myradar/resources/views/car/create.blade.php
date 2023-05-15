@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create New Car for {{ $user->name }}
                </div>
                <div class="panel-body">
                    <form action="/car/save" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td><input type="text" name="name" class="form-control" value=""></td>
                                </tr>
                                <tr>
                                    <td>Manufacturer</td>
                                    <td>
                                        <select class="form-control" name="maker">
                                            <option value="0">Select Manufacturer</option>
                                            @foreach ($makers as $key => $maker)
                                                <option value="{{$maker->id}}">{{$maker->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Model</td>
                                    <td><input type="text" name="model" value="" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Device SIM no.</td>
                                    <td><input type="text" name="sim_no" value="" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Reg no.</td>
                                    <td><input type="text" name="reg_no" value="" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Engine no.</td>
                                    <td><input type="text" name="engine_no" value="" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Chesis no.</td>
                                    <td><input type="text" name="chesis_no" value="" class="form-control"></td>
                                </tr>

                                <tr>
                                    <td>Reg. date</td>
                                    <td><input type="text" name="reg_date" value="" class="form-control" data-toggle="datepicker"></td>
                                </tr>
                                <tr>
                                    <td>Tax date</td>
                                    <td><input type="text" name="tax_date" value="" class="form-control" data-toggle="datepicker"></td>
                                </tr>
                                <tr>
                                    <td>Fitness date</td>
                                    <td><input type="text" name="fitness_date" value="" class="form-control" data-toggle="datepicker"></td>
                                </tr>
                                <tr>
                                    <td>Insurance date</td>
                                    <td><input type="text" name="insurance_date" value="" class="form-control" data-toggle="datepicker"></td>
                                </tr>

                                <tr>
                                    <td>Color</td>
                                    <td>
                                        <select class="form-control" name="color">
                                            <option value="0">Select Color</option>
                                            <option value="{{App\Entities\Car::$COLOR_BLACK}}">Black</option>
                                            <option value="{{App\Entities\Car::$COLOR_WHITE}}">White</option>
                                            <option value="{{App\Entities\Car::$COLOR_RED}}">Red</option>
                                            <option value="{{App\Entities\Car::$COLOR_ASH}}">Ash</option>
                                            <option value="{{App\Entities\Car::$COLOR_BLUE}}">Blue</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>
                                        <select class="form-control" name="type">
                                            <option value="0">Select Vehicle Type</option>
                                            <option value="{{App\Entities\Car::$TYPE_CAR}}">Car</option>
                                            <option value="{{App\Entities\Car::$TYPE_MICRO}}">Micro</option>
                                            <option value="{{App\Entities\Car::$TYPE_BIKE}}">Bike</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fuel Type</td>
                                    <td>
                                        <select class="form-control" name="fuel">
                                            <option value="0">Select Fuel Type</option>
                                            <option value="{{App\Entities\Car::$FUEL_GAS}}">Gas</option>
                                            <option value="{{App\Entities\Car::$FUEL_PETROL}}">Petrol</option>
                                            <option value="{{App\Entities\Car::$FUEL_DISEL}}">Disel</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Engine CC</td>
                                    <td><input type="text" name="engine_cc" value="" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Seat no.</td>
                                    <td><input type="text" name="seat_count" value="" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>CNG</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="1" name="cng" checked="">

                                            </label>
                                        </div>
                                  
                                    </td>
                                </tr>
                                <tr>
                                    <td>Note</td>
                                    <td><textarea name="note" rows="4" class="form-control"></textarea></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><button type="submit" class="btn btn-success btn-sm">SAVE</button></td>
                                </tr>

                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="panel-footer">
                    <a href="/customer/cars/{{$user->id}}" class="btn btn-link">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('js/datepicker.min.js') }}" charset="utf-8"></script>
    <script type="text/javascript">
        $(function() {
            $('[data-toggle="datepicker"]').datepicker();
        });
    </script>
@endsection
