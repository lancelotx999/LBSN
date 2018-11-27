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
			<span class="d-none d-sm-block d-md-none"><hr /></span>
		</div>
        <div class="col-md-10">
        	<div class="card">
				<div class="card-header">
					Profile Information&nbsp;&#8212;
					<a href="{{ route('user.edit', Auth::id()) }}">
						<i class="fas fa-user-edit fa-fw"></i> Edit my profile
					</a>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-3 col-md-2 my-auto text-center">
							<img src="{{ $users->profileImage }}" alt="Profile image"
							class="img-fluid rounded" style="max-height: 128px" />
						</div>
						<div class="col-sm-9 col-md-10">
							<h4>
								{{ $users->name }}
								<small class="text-muted">
									{{ $users->role }}
								</small>
							</h4>
							<h6>Name</h6>
							<hr/>
							<h4>{{ $users->email }}</h4>
							<h6>Email</h6>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var read = "{{ $users }}";
    var json = read.replace(/&quot;/g, '"');
    var users = JSON.parse(json);

    console.log("---------- data ----------");
    console.log(users);
    console.log("---------- data ----------");
</script>

@endsection
