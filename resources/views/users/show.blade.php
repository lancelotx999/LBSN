@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h6>
				<a href="{{ url('/') }}">Home</a> 
				<i class="fas fa-angle-right"></i>
				<a href="{{ route('users.show', ['user' => Auth::user() ]) }}">Member</a>
			</h6><hr />
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-2">
			<div class="card">
				<div class="card-header">Account</div>
				<div class="card-body">
					<a class="btn btn-default" href="{{ route('users.show', ['user' => Auth::user() ]) }}">
						My Dashboard
					</a>

					<hr />

					<a class="btn btn-default" href="{{ route('users.edit', ['user' => Auth::user() ]) }}">
						My Profile
					</a>
				</div>
			</div>
		</div>
        <div class="col-md-10">
        	<div class="card">
				<div class="card-header">Profile Information</div>
				<div class="card-body">
					<h4>{{ $user->name }}</h4>
					<h6>Name</h6>
					<hr/>
					<h4>{{ $user->email }}</h4>
					<h6>Email</h6>
				</div>
			</div>
			<br />
			@if ($user->role == 'merchant')
				<div class="card">
					<div class="card-header">Recent Customers</div>
					<div class="card-body">
						<div class="table-responsive">
		        			<table id="myTable" class="table table-hover table-sm">
			        			<thead>
			        				<th>Name</th>
			        				<th>Email</th>
			        				<th>Property Name</th>
			        				<th>Property Address</th>
			        				<th>Property Status</th>
			        				<th>Latitude</th>
			        				<th>Longitude</th>
			        			</thead>

		        				<tbody>
									@foreach ($locations as $location)
										<tr>
											<td>{{ $users->where('_id', $location->user_id)[0]->name }}</td>
											<td>{{ $users->where('_id', $location->user_id)[0]->email }}</td>
											<td>{{ $location->locationDescription }}</td>
											<td>{{ $location->locationStatus }}</td>
											<td>{{ $location->locationRating }}</td>
											<td>{{ $location->locationLatitude }}</td>
											<td>{{ $location->locationLongitude }}</td>
										<tr/>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@else
				<div class="card">
					<div class="card-header">Recent Property Purchases</div>
					<div class="card-body">
						<div class="table-responsive">
		        			<table id="myTable" class="table table-hover table-sm">
			        			<thead>
			        				<th>Name</th>
			        				<th>Address</th>
			        				<th>Description</th>
			        				<th>Status</th>
			        				<th>Rating</th>
			        				<th>Latitude</th>
			        				<th>Longitude</th>
			        			</thead>

		        				<tbody>
									@foreach ($locations as $location)
										<tr>
											<td>{{ $location->locationName }}</td>
											<td>{{ $location->locationAddress }}</td>
											<td>{{ $location->locationDescription }}</td>
											<td>{{ $location->locationStatus }}</td>
											<td>{{ $location->locationRating }}</td>
											<td>{{ $location->locationLatitude }}</td>
											<td>{{ $location->locationLongitude }}</td>
										<tr/>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
        </div>
    </div>
</div>
@endsection
