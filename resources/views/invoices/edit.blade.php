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

                        <h4>{{ $contract->name }}</h4>
                        <div class="form-group">
                            <label for="name">
                                Contract Title:
                            </label>
                            <input type="text" name="name" id="name"
                            class="form-control" placeholder="{{ $contract->name }}.."
                            value="{{ $contract->name }}" />
                        </div>
                        <div class="form-group">
                            <label>
                                Contract Type:
                            </label>
                            <div class="form-check">
                                <input 
                                    id="forrent" name="type" type="radio"
                                    class="form-check-input" value="rent" 
                                    checked 
                                />
                                <label class="form-check-label" for="forrent">
                                    Rent
                                </label>
                            </div>
                            <div class="form-check">
                                <input 
                                    id="forsale" name="type" type="radio"
                                    class="form-check-input" value="sell" 
                                />
                                <label class="form-check-label" for="forsale">
                                    Sale
                                </label>
                            </div>
                            <div class="form-check">
                                <input 
                                    id="forservice" name="type" type="radio"
                                    class="form-check-input" value="service" 
                                />
                                <label class="form-check-label" for="forservice">
                                    Service
                                </label>
                            </div>
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
                                Price:
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
                        <input
                            id="provider_id" name="provider_id" type="hidden"
                            class="form-control"
                            placeholder="Enter provider ID."
                            value="{{ $contract->provider_id }}"
                            required
                        />
                        <input
                            id="receiver_id" name="receiver_id" type="hidden"
                            class="form-control"
                            placeholder="Enter receiver ID."
                            value="{{ $contract->receiver_id }}"
                            required
                        />
                        <input
                            id="item_id" name="item_id" type="hidden"
                            class="form-control"
                            value="{{ $contract->item_id }}"
                            placeholder="Enter item ID."
                        />
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