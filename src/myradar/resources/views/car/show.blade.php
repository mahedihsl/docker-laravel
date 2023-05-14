@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Car Details
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Owner</td>
                                <td><a href="/customer/details/{{$car->user->id}}">{{$car->user->name}}</a></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><strong>{{$car->name or '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>Manufacturer</td>
                                <td><strong>{{$car->manufacturer ? $car->manufacturer->name : '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>Model</td>
                                <td><strong>{{$car->model or '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>SIM no.</td>
                                <td><strong>{{$car->device->iccid or '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>Reg no.</td>
                                <td><strong>{{$car->reg_no or '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>Engine no.</td>
                                <td><strong>{{$car->engine_no or '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>Chesis no.</td>
                                <td><strong>{{$car->chesis_no or '--'}}</strong></td>
                            </tr>

                            <tr>
                                <td>Reg. date</td>
                                <td><strong>{{$car->reg_date ? $car->reg_date->toFormattedDateString() : '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>Tax date</td>
                                <td><strong>{{$car->tax_date ? $car->tax_date->toFormattedDateString() : '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>Fitness date</td>
                                <td><strong>{{$car->fitness_date ? $car->fitness_date->toFormattedDateString() : '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>Insurance date</td>
                                <td><strong>{{$car->insurance_date ? $car->insurance_date->toFormattedDateString() : '--'}}</strong></td>
                            </tr>

                            <tr>
                                <td>Color</td>
                                <td><strong>{{$car->color_name}}</strong></td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td><strong>{{$car->type_name}}</strong></td>
                            </tr>
                            <tr>
                                <td>Fuel Type</td>
                                <td><strong>{{$car->fuel_name}}</strong></td>
                            </tr>
                            <tr>
                                <td>Engine CC</td>
                                <td><strong>{{$car->engine_cc or '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>Seat no.</td>
                                <td><strong>{{$car->seat_count or '--'}}</strong></td>
                            </tr>
                            <tr>
                                <td>CNG</td>
                                <td><strong>{{$car->cng ? 'Yes' : 'No'}}</strong></td>
                            </tr>
                            <tr>
                                <td>Note</td>
                                <td><strong>{{$car->note or '--'}}</strong></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <a href="/customer/cars/{{$user->id}}" class="btn btn-link">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <a href="/car/position/{{$car->id}}" class="btn btn-link">
                        <i class="fa fa-map-marker"></i> Position
                    </a>
                    <a href="/car/edit/{{$car->id}}" class="btn btn-link">
                        <i class="fa fa-pencil"></i> Edit
                    </a>
                    <a href="/car/delete/{{$car->id}}" class="btn btn-link">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')

@endsection
