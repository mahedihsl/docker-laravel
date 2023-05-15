@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Update Customer
                </div>

                <div class="panel-body">
                    <form class="form" action="/customer/update" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$user->id}}">

                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4">
                                <input type="file" name="image" value="" style="display: none;">
                                <img id="profile-image" src="{{$user->image_url}}" alt="" class="img img-circle img-profile">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="{{$user->name}}">
                                    <p class="help-block">{{ $errors->first('name') }}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="{{$user->phone}}">
                                    <p class="help-block">{{ $errors->first('phone') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <div class="form-group">
                                    <label for="nid">National ID</label>
                                    <input type="text" class="form-control" id="nid" name="nid" placeholder="National ID" value="{{$user->nid}}">
                                    <p class="help-block">{{ $errors->first('nid') }}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="type">Customer Type</label>
                                    <select class="form-control" name="type" id="type" data-real="{{ $user->customer_type }}">
                                        <option value="0">Select Type</option>
                                        <option value="{{ App\Entities\User::$CUSTOMER_PRIVATE }}">Private Customer</option>
                                        <option value="{{ App\Entities\User::$CUSTOMER_ENTERPRISE }}">Enterprise Customer</option>
                                        <option value="{{ App\Entities\User::$CUSTOMER_PUBLIC }}">Public Customer</option>
                                    </select>
                                    <p class="help-block">{{ $errors->first('type') }}</p>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" rows="5" class="form-control">{{$user->address}}</textarea>
                                    <p class="help-block">{{ $errors->first('address') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <textarea name="note" rows="4" class="form-control">{{$user->note or ''}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2 col-sm-offset-5">
                                <button type="submit" class="btn btn-success btn-sm btn-block">
                                    <i class="fa fa-save"></i> UPDATE
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#profile-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function() {
            $('#profile-image').click(function() {
                $('input[name="image"]').click();
            });

            $('input[name="image"]').change(function() {
                readURL(this);
            });
        });
    </script>
@endsection
