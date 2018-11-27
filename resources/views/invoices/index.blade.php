@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('invoice.index') }}">My Invoices</a>
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
                class="list-group-item list-group-item-action">
                    My Contracts
                </a>
                <a href="{{ route('invoice.index') }}" 
                class="list-group-item list-group-item-action active">
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
                <div class="card-header">Invoices</div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="provided-tab" data-toggle="tab" href="#provided" 
                        role="tab" aria-controls="provided" aria-selected="true">
                            Invoices Provided
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="received-tab" data-toggle="tab" href="#received" 
                        role="tab" aria-controls="received" aria-selected="false">
                            Invoices Received
                        </a>
                    </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="provided" 
                    role="tabpanel" aria-labelledby="home-tab"><br />
                    @if ($provided_invoices->isEmpty())
                        <h3 class="display-4">Empty!</h3>
                        <p class="lead">No invoices have been provided yet.</p>
                        <hr />
                    @endif
                    @foreach ($provided_invoices as $invoice)
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>
                                Invoice: 
                                {{ App\Contract::find($invoice->contract_id)->first()->name }}
                            </h4>
                            <p>
                                <strong>Status:</strong>
                                @if ($invoice->paid)
                                    Already paid
                                @else
                                    Not yet paid
                                @endif
                            </p>
                            <hr />
                            <ul class="list-unstyled">
                                <li>
                                    <strong>Sent To:</strong> 
                                    {{ App\User::find($invoice->customer_id)->name }}
                                </li>
                                <li>
                                    <strong>Grand Total:</strong> 
                                    RM {{ $invoice->grand_total }}
                                </li>
                                <li>
                                    <strong>Outstanding Payment:</strong> 
                                    RM {{ $invoice->outstanding_payment }}
                                </li>
                            </ul>
                            <a class="nounderline" 
                            href="{{ route('invoice.show', $invoice->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-list fa-fw"></i> View
                                </button>
                            </a>
                            @if ($invoice->merchant_id == Auth::id())
                            <a class="nounderline" 
                            href="{{ route('invoice.edit', $invoice->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-edit fa-fw"></i> Edit
                                </button>
                            </a>
                            <button type="button" class="btn btn-sm btn-light" data-toggle="modal" 
                            data-target="#deleteModal{{ $invoice->_id }}">
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
                    @if ($received_invoices->isEmpty())
                        <h3 class="display-4">Empty!</h3>
                        <p class="lead">No invoices have been received yet.</p>
                        <hr />
                    @endif
                    @foreach ($received_invoices as $invoice)
                        <div class="row">
                        <div class="col-sm-12">
                            <h4>
                                Invoice: 
                                {{ App\Contract::find($invoice->contract_id)->first()->name }}
                            </h4>
                            <p>
                                <strong>Status:</strong>
                                @if ($invoice->paid)
                                    Already paid
                                @else
                                    Not yet paid
                                @endif
                            </p>
                            <hr />
                            <ul class="list-unstyled">
                                <li>
                                    <strong>Sent By:</strong> 
                                    {{ App\User::find($invoice->merchant_id)->name }}
                                </li>
                                <li>
                                    <strong>Grand Total:</strong> 
                                    RM {{ $invoice->grand_total }}
                                </li>
                                <li>
                                    <strong>Outstanding Payment:</strong> 
                                    RM {{ $invoice->outstanding_payment }}
                                </li>
                            </ul>
                            <a class="nounderline" 
                            href="{{ route('invoice.show', $invoice->_id) }}">
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-list fa-fw"></i> View
                                </button>
                            </a>
                            @if ($invoice->customer_id == Auth::id())
                            <a class="nounderline" 
                            href="/transaction/create/{{ $invoice->_id }}">
                                <button class="btn btn-sm btn-primary" type="button">
                                    <i class="fas fa-file-signature fa-fw"></i>
                                    Create a new transaction
                                </button>
                            </a>
                            <button type="button" class="btn btn-sm btn-light" data-toggle="modal" 
                            data-target="#deleteModal{{ $invoice->_id }}">
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
@foreach ($provided_invoices as $invoice)
<div class="modal fade" id="deleteModal{{ $invoice->_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            action="{{ route('invoice.destroy', $invoice->_id) }}">
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

@foreach ($received_invoices as $invoice)
<div class="modal fade" id="deleteModal{{ $invoice->_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            action="{{ route('invoice.destroy', $invoice->_id) }}">
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
