@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Customer Details
                </div>
                <div class="panel-body">
                    <div class="row row-eq-height vcenter">
                        <div class="col-sm-2 col-sm-offset-2">
                            <img src="{{$user->image_url}}" alt="" class="img img-circle img-profile-inline">
                            <span class="label label-primary">{{$user->customer_type}}</span>
                        </div>
                        <div class="col-sm-10">
                            <span class="title">{{$user->name}}</span>
                            <strong><i class="fa fa-phone marg-right-10"></i> {{$user->phone}}</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-4">
                            <span class="material-label">Details</span>
                            @include('customer.comp.info-item', [
                                'icon' => 'envelope',
                                'value' => $user->email,
                                'label' => 'Email'
                            ])
                            @include('customer.comp.info-item', [
                                'icon' => 'id-card',
                                'value' => $user->nid,
                                'label' => 'National ID'
                            ])
                            @include('customer.comp.info-item', [
                                'icon' => 'map-marker',
                                'value' => $user->address,
                                'label' => 'Address'
                            ])
                            @include('customer.comp.info-item', [
                                'icon' => 'car',
                                'value' => $user->cars()->count(),
                                'label' => 'Vehicle Count'
                            ])
                            @include('customer.comp.info-item', [
                                'icon' => 'calendar-plus-o',
                                'value' => $user->created_at->format('d M Y'),
                                'label' => 'Registered On'
                            ])
                            @include('customer.comp.info-item', [
                                'icon' => 'commenting',
                                'value' => $user->note,
                                'label' => 'Note'
                            ])
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="/customers" class="btn btn-link">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <a href="/customer/cars/{{$user->id}}" class="btn btn-link">
                        <i class="fa fa-car"></i> Cars
                    </a>

                    @if(isset($device)&& $device!==null)

                    <a href="/customer/services/{{$user->id}}" class="btn btn-link">
                        <i class="fa fa-stack"></i>Assigned services
                    </a>
                    @endif
                    <a href="/customer/edit/{{$user->id}}" class="btn btn-link">
                        <i class="fa fa-pencil"></i> Edit
                    </a>
                    <a href="/customer/delete/{{$user->id}}" class="btn btn-link">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')

@endsection
