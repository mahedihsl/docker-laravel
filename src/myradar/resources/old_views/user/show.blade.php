@extends('layouts.new')

@section('content')
  <table class="table">
    <tbody>
      <tr>
        <td>Name</td>
        <td><strong>{{$user->name}}</strong></td>
      </tr>
      <tr>
        <td>Type</td>
        <td><strong>{{$user->type_name}}</strong></td>
      </tr>
      <tr>
        <td>Phone</td>
        <td><strong>{{$user->phone}}</strong></td>
      </tr>
      <tr>
        <td>National ID</td>
        <td><strong>{{$user->nid or '--'}}</strong></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><strong>{{$user->email}}</strong></td>
      </tr>
      <tr>
        <td>Since</td>
        <td><strong>{{$user->created_at->format('d M Y')}}</strong></td>
      </tr>
      <tr>
        <td>Note</td>
        <td><strong>{{$user->note or '--'}}</strong></td>
      </tr>
    </tbody>
  </table>
@endsection
