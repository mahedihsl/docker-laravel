@extends('layouts.new')

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <a href="{{ url('/recharge/create') }}" class="btn btn-success btn-sm" title="Add New recharge">
        <i class="fa fa-plus" aria-hidden="true"></i> Add New
      </a>
      @if(Session::has('flash_message'))
        {{ Session::get('flash_message')}}
      @endif
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover table-responsive">
          <thead>
            <tr>
              <th>Phone</th>
              <th>Amount</th>
              <th>Volume</th>
              <th>Remaining</th>

              <th>Validity</th>
              <th>Recharge Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($recharge as $item)
              <tr>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->amount }}</td>
                <td>{{ $item->volume }}</td>
                <td>{{ $item->remained }}</td>
                <td> {{ Carbon\Carbon::parse($item->validity)->format('d M Y') }}</td>
                <td> {{ Carbon\Carbon::parse($item->recharged_at)->format('d M Y') }}</td>
                <td>
                  <a href="{{ url('/recharge/' . $item->id) }}" title="View recharge">
                    <button class="btn btn-info btn-xs">
                      <i class="fa fa-eye" aria-hidden="true"></i> View
                    </button>
                  </a>
                    <!-- <a href="{{ url('/recharge/' . $item->id . '/edit') }}" title="Edit recharge"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                    {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['/recharge', $item->id],
                        'style' => 'display:inline'
                    ]) !!}
                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'title' => 'Delete recharge',
                                'onclick'=>'return confirm("Confirm delete?")'
                        )) !!}
                    {!! Form::close() !!} -->
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="pagination-wrapper">
          {!! $recharge->appends(['search' => Request::get('search')])->render() !!}
        </div>
      </div>
    </div>
  </div>
@endsection
