@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h6>
				<a href="{{ url('/') }}">Home</a> 
				<i class="fas fa-angle-right"></i>
				<a href="{{ route('users.show', ['user' => Auth::id() ]) }}">Member</a>
				<i class="fas fa-angle-right"></i>
                <a href="{{ route('users.contract', ['user' => Auth::id() ]) }}">Contract</a>
			</h6><hr />
		</div>
	</div>
    <div class="row justify-content-center">
    	<div class="col-md-2">
			<div class="card">
				<div class="card-header">Account</div>
				<div class="card-body">
					<a class="btn btn-default" href="{{ route('users.show', ['user' => Auth::id() ]) }}">
						My Dashboard
					</a>

					<hr />
					
					<a class="btn btn-default" href="{{ route('users.edit', ['user' => Auth::id() ]) }}">
						My Profile
					</a>

                    <hr />

                    <a class="btn btn-default" href="{{ route('users.contract', ['user' => Auth::id() ]) }}">
                        My Contract
                    </a>
				</div>
			</div>
		</div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Contract List</div>

                <div class="card-body">                	
					<p>Show me dat contract list boi</p>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection
