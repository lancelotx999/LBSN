@extends('layouts.app')

@section('content')

@if ( $user->role == 'admin' )
	<style type="text/css">
		#myInput {
		    width: 100%; /* Full-width */
		    font-size: 16px; /* Increase font-size */
		    padding: 12px 20px; /* Add some padding */
		    border: 1px solid #ddd; /* Add a grey border */
		    margin-bottom: 18px; /* Add some space below the input */
		}
	</style>
@endif

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
					<h4>{{ $user->name }}, {{ $user->role }}</h4>
					<h6>Name</h6>
					<hr/>
					<h4>{{ $user->email }}</h4>
					<h6>Email</h6>
				</div>
			</div>
			<br />
			@if ($user->role == 'admin')
	        	<div class="card">
	        		<div class="card-header">Manage Profiles</div>

	        		<div class="card-body">
	        			<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for user..">
	        			<div class="table-responsive">
		        			<table id="myTable" class="table table-hover table-sm">
			        			<thead>
			        				<th>Name</th>
			        				<th>Email</th>
			        				<th>Role</th>
			        				<th>Created</th>
			        				<th>Updated</th>
			        				<th>&nbsp;</th>
			        				<th>&nbsp;</th>
			        			</thead>

		        				<tbody>
		        					@foreach($users as $all)
		        						<tr>
		        							<td class="align-middle">
		        								{{ $all->name }}
		        							</td>
		        							<td class="align-middle">
		        								{{ $all->email }}
		        							</td>
		        							<td class="align-middle">
		        								{{ $all->role }}
		        							</td>
		        							<td class="align-middle">
		        								{{ $all->created_at ? $all->created_at : "-" }}
		        							</td>
		        							<td class="align-middle">
		        								{{ $all->updated_at ? $all->updated_at : "-"  }}
		        							</td>
		        							<td class="align-middle">
		        								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-modal-{{ $all->id }}">
		        									<i class="fas fa-edit"></i>
		        								</button>
		        							</td>
		        							<td class="align-middle">
		        								<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#delete-modal-{{ $all->id }}">
		        									<i class="fas fa-trash-alt"></i>
		        								</button>
		        							</td>
		        						</tr>
		        					@endforeach
		        				</tbody>
		        			</table>
		        		</div>
	        		</div>
	        	</div>
	        <br />
        	@endif

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
			@elseif ($user->role == 'user' || $user->role == 'merchant')
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

@if($user->role == 'admin')
	@foreach($users as $all)
	<!-- Edit Modal -->
	<div class="modal fade" id="edit-modal-{{ $all->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<h5 class="modal-title" id="exampleModalLabel">Edit User Profile</h5>
	    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	      				<span aria-hidden="true">&times;</span>
	    			</button>
	      		</div>
		      	<div class="modal-body">
		        	<form method="POST" action="{{ route('users.update', $all) }}" aria-label="Edit Profile">
					    @csrf
					    @method('PATCH')

					    <div class="form-group row">
	                        <label for="name-{{ $all->id }}" class="col-sm-4 col-form-label text-md-right">New Name</label>

	                        <div class="col-md-6">
	                            <input id="name-{{ $all->id }}" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $all->name }}" autofocus required>

	                            @if ($errors->has('name'))
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $errors->first('name') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

						<div class="form-group row">
	                        <label for="email-{{ $all->id }}" class="col-sm-4 col-form-label text-md-right">New Email</label>

	                        <div class="col-md-6">
	                            <input id="email-{{ $all->id }}" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $all->email }}" required>

	                            @if ($errors->has('email'))
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $errors->first('email') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

	                    <div class="form-group row">
	                    	<label for="role-{{ $all->id }}" class="col-sm-4 col-form-label text-md-right">New Role</label>

	                    	<div class="col-md-6">
	                    		<select id="role-{{ $all->id }}" name="role" class="custom-select">
	                    			<option value="user" selected>User</option>
	                    			<option value="merchant">Admin</option>
	                    			<option value="admin">Admin</option>
	                    		</select>
	                    	</div>
	                    </div>

					    <div class="form-group row">
	                        <label for="password-{{ $all->id }}" class="col-md-4 col-form-label text-md-right">New Password</label>

	                        <div class="col-md-6">
	                            <input id="password-{{ $all->id }}" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

	                            @if ($errors->has('password'))
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $errors->first('password') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

					    <div class="form-group row">
	                        <label for="confirm-{{ $all->id }}" class="col-md-4 col-form-label text-md-right">
	                        	Confirm Password
	                        </label>

	                        <div class="col-md-6">
	                        	<input id="confirm-{{ $all->id }}" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>

	                            @if ($errors->has('password'))
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
	                                </span>
	                            @endif
					    	</div>
					    </div>

					    <div class="form-group row mb-0">
	                        <div class="col-md-8 offset-md-4">
					    		<button type="submit" class="btn btn-primary">Update</button>
					    		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					    	</div>
					    </div>
					</form>
		      	</div>
		      	<div class="modal-footer"></div>
	    	</div>
	  	</div>
	</div>

	<!-- Delete Modal -->
	<div class="modal fade" id="delete-modal-{{ $all->id }}" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<h5 class="modal-title" id="exampleModalLabel">Delete User Profile</h5>
	    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	      				<span aria-hidden="true">&times;</span>
	    			</button>
	      		</div>
		      	<div class="modal-body">
		      		<p>Are you sure you want to delete {{ $all->name }}?</p>
		      		<form method="POST" action="{{ route('users.destroy', $all) }}" aria-label="Delete Profile">
					    @csrf
					    @method('DELETE')

					    <div class="form-group row mb-0">
	                        <div class="col-md-8">
	                        	<button type="submit" class="btn btn-light">Delete</button>
					    		<button type="button" class="btn btn-primary" data-dismiss="modal">Reconsider</button>
					    	</div>
					    </div>
					</form>
		      	</div>
		      	<div class="modal-footer"></div>
	      	</div>
		</div>
	</div>
	@endforeach

	<script type="text/javascript">
		function myFunction() {
	  		// Declare variables 
	  		var input, filter, table, tr, td, i;
	  		input = document.getElementById("myInput");
	  		filter = input.value.toUpperCase();
	  		table = document.getElementById("myTable");
	  		tr = table.getElementsByTagName("tr");

	  		// Loop through all table rows, and hide those who don't match the search query
	  		for (i = 0; i < tr.length; i++) {
	    		td = tr[i].getElementsByTagName("td")[0];
	    		if (td) {
	      			if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        			tr[i].style.display = "";
	      			} else {
	        			tr[i].style.display = "none";
	      			}
	    		} 
	  		}
		}
	</script>
@endif

@endsection
