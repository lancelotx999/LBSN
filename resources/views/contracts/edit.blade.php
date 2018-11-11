@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.index') }}">Contracts</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.edit', $contract->_id) }}">Edit Contract: {{ $contract->name }}</a>
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
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Contract</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('contract.update', $contract) }}">
                    	@csrf
                    	@method('PATCH')

                        <div class="form-group">
                            <label for="provider_id">
                                Provider:
                            </label>
                            <input
                                id="provider_id" name="provider_id" type="text"
                                class="form-control"
                                placeholder="Enter provider ID."
                                value="{{ $contract->provider_id }}" 
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="receiver_id">
                                Receiver:
                            </label>
                            <input
                                id="receiver_id" name="receiver_id" type="text"
                                class="form-control"
                                placeholder="Enter receiver ID."
                                value="{{ $contract->receiver_id }}" 
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="item_id">
                                Property:
                            </label>
                            <input
                                id="item_id" name="item_id" type="text"
                                class="form-control"
                                placeholder="Enter item ID."
                                value="{{ $contract->item_id }}" 
                            />
                        </div>
                        <div class="form-group">
                            <label for="type">
                                Contract Type:
                            </label>
                            <input
                                id="type" name="type" type="text"
                                class="form-control"
                                placeholder="Enter contract type."
                                value="{{ $contract->type }}" 
                            />
                        </div>
                        <div class="form-group">
                            <label for="description">
                                Description:
                            </label>
                            <textarea 
                                id="description" name="description"
                                class="form-control" rows="3"
                                placeholder="Enter description."
                                >{{ $contract->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">
                                Property Price:
                            </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                    <span class="input-group-text">MYR</span>
                                </div>
                                <input 
                                    id="price" name="price" type="text" 
                                    class="form-control" 
                                    placeholder="Enter price value."
                                    value="{{ $contract->price }}" 
                                    required
                                />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Edit Contract
                        </button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
