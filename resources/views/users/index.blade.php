@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h6>
				<a href="{{ url('/') }}">Home</a> 
				<i class="fas fa-angle-right"></i>
				<a href="{{ route('user.index') }}">My Dashboard</a>
			</h6><hr />
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-2">
			<div class="list-group">
				<a href="{{ route('user.index') }}" 
				class="list-group-item list-group-item-action active">
					My Dashboard
				</a>
				<a href="{{ route('user.edit', Auth::id()) }}" 
				class="list-group-item list-group-item-action">
					My Profile
				</a>
			</div>
		</div>
        <div class="col-md-10">
        	<div class="card">
				<div class="card-header">Profile Information</div>
				<div class="card-body">
					
					<h4>{{ $users->name }}, {{ $users->role }}</h4>
					<h6>Name</h6>
					<hr/>
					<h4>{{ $users->email }}</h4>
					<h6>Email</h6>
					
				</div>
			</div>
        </div>
    </div>
</div>

@endsection
