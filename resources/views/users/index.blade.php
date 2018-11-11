@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h6>
				<a href="{{ url('/') }}">Home</a> 
				<i class="fas fa-angle-right"></i>
				<a href="{{ route('user.index') }}">My Profile</a>
			</h6><hr />
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-2">
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
        <div class="col-md-10">
        	<div class="card">
				<div class="card-header">
					Profile Information
					<small><a href="{{ route('user.edit', Auth::id()) }}">Edit</a></small>
				</div>
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
