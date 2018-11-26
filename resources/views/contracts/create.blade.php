@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                @if (strpos(url()->previous(), 'property'))
                <a href="{{ url('/property/listing') }}">Properties</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('property.show', $item->_id) }}">View {{ $item->name }}</a>
                @elseif (strpos(url()->previous(), 'business'))
                <a href="{{ url('/business/listing') }}">Businesses</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('business.show', $item->_id) }}">View {{ $item->name }}</a>
                @endif
                <i class="fas fa-angle-right"></i>
                <a href="{{ url()->current() }}">Create New Contract</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Contract For:</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('contract.store') }}">
                    	@csrf
                    	@method('POST')

                        <h4>{{ $item->name }}</h4>
                        <div class="form-group">
                            <label for="name">
                                Contract Title:
                            </label>
                            <input type="text" name="name" id="name"
                            class="form-control" placeholder="{{ $item->name }}.." />
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
                                ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">
                                Price:
                            </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                    <span class="input-group-text">RM</span>
                                </div>
                                <input 
                                    id="price" name="price" type="number" 
                                    class="form-control" 
                                    placeholder="Enter price value."
                                    step="0.01" min="0" required
                                />
                            </div>
                        </div>
                        <input
                            id="customer_id" name="customer_id" type="hidden"
                            class="form-control"
                            placeholder="Enter Customer ID."
                            value="{{ Auth::id() }}"
                            required
                        />
                        <input
                            id="merchant_id" name="merchant_id" type="hidden"
                            class="form-control"
                            placeholder="Enter Merchant ID."
                            value="{{ $item->owner_id }}"
                            required
                        />
                        <input
                            id="item_id" name="item_id" type="hidden"
                            class="form-control"
                            value="{{ $item_id }}"
                            placeholder="Enter item ID."
                        />
                        <button type="submit" class="btn btn-primary">
                            Send Contract
                        </button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
