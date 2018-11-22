@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.index') }}">My Contracts</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="list-group">
                <a href="{{ route('user.index') }}" 
                class="list-group-item list-group-item-action">
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
                class="list-group-item list-group-item-action active">
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
                <div class="card-header">Contracts</div>
                <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="sent-tab" data-toggle="tab" href="#sent" 
                        role="tab" aria-controls="sent" aria-selected="true">
                            Contracts Sent
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="received-tab" data-toggle="tab" href="#received" 
                        role="tab" aria-controls="received" aria-selected="false">
                            Contracts Received
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="sent" 
                    role="tabpanel" aria-labelledby="home-tab"><br />
                    @if ($sent_contracts->isEmpty())
                        <h3 class="display-4">Empty!</h3>
                        <p class="lead">No contracts have been sent yet.</p>
                        <hr />
                    @endif
                    @foreach ($sent_contracts as $contract)
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>{{ $contract->name }}</h4>
                            <p>{{ $contract->description }}</p>
                            <hr />
                            <ul class="list-unstyled">
                                <li>
                                    <strong>Fulfilled:</strong> 
                                    @if ($contract->fulfilled)
                                        <span class="text-success">
                                            <i class="fas fa-check-circle fa-fw"></i>
                                        </span> Yes
                                    @else
                                        <span class="text-danger">
                                            <i class="fas fa-times-circle fa-fw"></i>
                                        </span> No
                                    @endif
                                </li>
                                <li>
                                    <strong>Price:</strong> 
                                    RM {{ $contract->price }}
                                </li>
                            </ul>
                            <a href="{{ route('contract.show', $contract->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-list fa-fw"></i> View
                                </button>
                            </a>
                            @if ($contract->provider_id == Auth::id())
                            @if ($contract->fulfilled)
                                <button class="btn btn-sm btn-success disabled" tabindex="-1">
                                    <i class="fas fa-edit fa-fw"></i> Edit
                                </button>
                            @else
                            <a href="{{ route('contract.edit', $contract->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-edit fa-fw"></i> Edit
                                </button>
                            </a>
                            @endif
                            <button type="button" class="btn btn-sm btn-light" data-toggle="modal" 
                            data-target="#deleteModal{{ $contract->_id }}">
                            <i class="fas fa-times fa-fw"></i> Delete
                            </button>
                            @endif
                        </div>
                    </div>
                    <hr />
                    @endforeach
                    </div>
                    <div class="tab-pane fade" id="received" 
                    role="tabpanel" aria-labelledby="profile-tab"><br />
                    @if ($received_contracts->isEmpty())
                        <h3 class="display-4">Empty!</h3>
                        <p class="lead">No contracts have been received yet.</p>
                        <hr />
                    @endif
                    @foreach ($received_contracts as $contract)
                        <div class="row">
                        <div class="col-sm-12">
                            <h4>{{ $contract->name }}</h4>
                            <p>{{ $contract->description }}</p>
                            <hr />
                            <ul class="list-unstyled">
                                <li>
                                    <strong>Accepted:</strong> 
                                    @if ($contract->accepted)
                                        <span class="text-success">
                                            <i class="fas fa-check-circle fa-fw"></i>
                                        </span> Yes
                                    @else
                                        <span class="text-danger">
                                            <i class="fas fa-times-circle fa-fw"></i>
                                        </span> No
                                    @endif
                                </li>
                                <li>
                                    <strong>Price:</strong> 
                                    RM {{ $contract->price }}
                                </li>
                            </ul>
                            <a href="{{ route('contract.show', $contract->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-list fa-fw"></i> View
                                </button>
                            </a>
                            @if ($contract->receiver_id == Auth::id())
                            @if ($contract->accepted)
                                <button class="btn btn-sm btn-success disabled" tabindex="-1">
                                    <i class="fas fa-edit fa-fw"></i> Edit
                                </button>
                            @else
                            <a href="{{ route('contract.edit', $contract->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-edit fa-fw"></i> Edit
                                </button>
                            </a>
                            @endif
                            <button type="button" class="btn btn-sm btn-light" data-toggle="modal" 
                            data-target="#deleteModal{{ $contract->_id }}">
                            <i class="fas fa-times fa-fw"></i> Delete
                            </button>
                            @endif
                        </div>
                    </div>
                    <hr />
                    @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
@foreach ($sent_contracts as $contract)
<div class="modal fade" id="deleteModal{{ $contract->_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Deletion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form method="POST" class="form-inline" 
            action="{{ route('contract.destroy', $contract->_id) }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">
                Delete Now
            </button>
        </form>
    </div>
</div>
</div>
</div>
@endforeach

@foreach ($received_contracts as $contract)
<div class="modal fade" id="deleteModal{{ $contract->_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Deletion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form method="POST" class="form-inline" 
            action="{{ route('contract.destroy', $contract->_id) }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">
                Delete Now
            </button>
        </form>
    </div>
</div>
</div>
</div>
@endforeach
@endsection
