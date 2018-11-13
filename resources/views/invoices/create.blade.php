@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.index') }}">My Contracts</a>
                @if (strpos(url()->previous(), 'contract'))
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.show', $contract->_id) }}">View {{ $contract->name }}</a>
                @endif
                <i class="fas fa-angle-right"></i>
                <a href="{{ url()->current() }}">Create New Invoice</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Invoice For:</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('invoice.store') }}">
                    	@csrf
                    	@method('POST')

                        <h4>{{ $contract->name }}</h4>
                        <div class="form-group">
                            <label for="tax">
                                Tax:
                            </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                    <span class="input-group-text">MYR</span>
                                </div>
                                <input 
                                    id="tax" name="tax" type="number" 
                                    class="form-control" 
                                    placeholder="Enter tax value."
                                    required
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="total_price">
                                Total Price:
                            </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                    <span class="input-group-text">MYR</span>
                                </div>
                                <input 
                                    id="total_price" name="total_price" type="number" 
                                    class="form-control" 
                                    placeholder="Enter total price value."
                                    required
                                />
                            </div>
                        </div>
                        <input type="hidden" name="contract_id[]" id="contract_id"
                        class="form-control" value="{{ $contract->_id }}" required />
                        <button type="submit" class="btn btn-primary">
                            Send Invoice
                        </button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
