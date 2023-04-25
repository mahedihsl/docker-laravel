@extends('layouts.new')

@push('style')

@endpush

@section('content')
<div id="app">
	<div class="col-xs-12">
		<h4>Unhealthy Devices</h4>
		<table class="table-responsive table-striped">
			<thead>
				<tr>
					<th class="col-xs-1 text-center">#</th>
					<th class="col-xs-2 text-center">Com. ID</th>
					<th class="col-xs-1 text-center">Version</th>
					<th class="col-xs-2 text-center">Last Pulse</th>
					<th class="col-xs-2 text-center">Reset Count</th>
					<th class="col-xs-2 text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($items as $key => $dev)
				<tr>
					<td class="text-center">{{ $key + 1 }}</td>
					<td class="text-center">{{ $dev['com_id'] }}</td>
					<td class="text-center">{{ $dev['version'] }}</td>
					<td class="text-center">{{ $dev['last_pulse'] }}</td>
					<td class="text-center" style="font-weight: bold;">
						<span class="text-primary">{{ $dev['count'] }}</span>
						(<span class="text-success">{{ $dev['on_count'] }}</span> +
						<span class="text-danger">{{ $dev['off_count'] }}</span>)
					</td>
					<td class="text-center">
						<a href="{{ $dev['target'] }}" class="btn btn-link">View</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection

@push('script')

@endpush
