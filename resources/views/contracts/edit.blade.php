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
            <span class="d-none d-sm-block d-md-none"><hr /></span>
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
                            <label>
                                Accept Contract:
                            </label>
                            <div class="form-check">
                                <input 
                                    id="forrent" name="type" type="radio"
                                    class="form-check-input" value="false" 
                                    checked 
                                />
                                <label class="form-check-label" for="forrent">
                                    No
                                </label>
                            </div>
                            <div class="form-check">
                                <input 
                                    id="forsale" name="type" type="radio"
                                    class="form-check-input" value="true" 
                                />
                                <label class="form-check-label" for="forsale">
                                    Yes
                                </label>
                            </div>
                        </div>
                        <div class="accordion" id="accordionExample">
                        <button class="btn btn-link" type="button" 
                        data-toggle="collapse" data-target="#collapseOne" 
                        aria-expanded="true" aria-controls="collapseOne">
                            <i class="fas fa-chevron-circle-down fa-fw"></i> 
                            Click here to write a review
                        </button>
                        <div 
                            id="collapseOne" class="collapse" 
                            aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="form-group">
                            <hr />
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
                            id="customer_id" name="customer_id" type="hidden"
                            class="form-control"
                            placeholder="Enter Customer ID."
                            value="{{ $contract->customer_id }}"
                            required
                        />
                        <input
                            id="merchant_id" name="merchant_id" type="hidden"
                            class="form-control"
                            placeholder="Enter Merchant ID."
                            value="{{ $contract->merchant_id }}"
                            required
                        />
                        <input
                            id="item_id" name="item_id" type="hidden"
                            class="form-control"
                            value="{{ $contract->item_id }}"
                            placeholder="Enter item ID."
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
