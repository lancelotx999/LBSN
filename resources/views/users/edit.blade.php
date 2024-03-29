@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h6>
				<a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('user.index') }}">My Profile</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('user.edit', Auth::id()) }}">Edit Profile</a>
			</h6><hr />
		</div>
	</div>
    <div class="row justify-content-center">
    	<div class="col-md-2">
			<div class="card">
				<div class="list-group">
                <a href="{{ route('user.index') }}" 
                class="list-group-item list-group-item-action active">
                    My Profile
                </a>
                <a href="{{ route('property.index') }}" 
                class="list-group-item list-group-item-action">
                    My Properties
                </a>
                <a href="{{ route('business.index') }}" 
                class="list-group-item list-group-item-action">
                    My Businesses
                </a>
                <a href="{{ route('contract.index') }}" 
                class="list-group-item list-group-item-action">
                    My Contracts
                </a>
                <a href="{{ route('invoice.index') }}" 
                class="list-group-item list-group-item-action">
                    My Invoices
                </a>
                <a href="{{ route('transaction.index') }}" 
                class="list-group-item list-group-item-action">
                    My Transactions
                </a>
            </div>

			</div>
		</div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Profile</div>
                <div class="card-body">                	
					<form method="POST" action="{{ route('user.update', $user) }}" aria-label="Edit Profile" enctype="multipart/form-data">
					    @csrf
					    @method('PATCH')

                        <div class="form-group">
                            <div class="col-md-6 offset-md-4">
                                <img class="img-fluid img-rounded" alt="Profile Picture"
                                src="{{ $user->profileImage }}" style="max-height: 128px" />
                            </div>
                        </div>

					    <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">Change My Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"> Change E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

					    <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Change Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

					    <div class="form-group row">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">
                            	Confirm Password
                            </label>

                            <div class="col-md-6">
                            	<input id="password_confirmation" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
					    	</div>
					    </div>

						<div class="form-group row">
							<label for="profileImage" class="col-md-4 col-form-label text-md-right">
                                Change Profile Picture:
                            </label>

                            <div class="col-md-6">
							    <input type="file" id="profileImage" name="profileImage" 
                                accept="image/png, image/jpeg">
                            </div>
					    </div>

					    <div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<input type="hidden" name="role" value="{{ $user->role }}">
                            	<input type="hidden" name="id" value="{{ $user->id }}">
					    		<button type="submit" class="btn btn-primary">Update Profile</button>
					    	</div>
					    </div>
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection
