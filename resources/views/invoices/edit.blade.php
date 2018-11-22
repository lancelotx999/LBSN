@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('invoice.index') }}">Invoices</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('invoice.edit', $invoice->_id) }}">
                    Edit Invoice: {{ App\Contract::find($invoice->contract_id)[0]->name }}
                </a>
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
                <div class="card-header">Edit Invoice</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('invoice.update', $invoice) }}">
                    	@csrf
                    	@method('PATCH')

                        <h4>{{ App\Contract::find($invoice->contract_id)[0]->name }}</h4>
                        <div class="form-group">
                            <label for="paid">
                                Payment Status:
                            </label>
                            <div class="form-check">
                                <input 
                                    id="forrent" name="paid" type="radio"
                                    class="form-check-input" value="false" 
                                    checked 
                                />
                                <label class="form-check-label text-uppercase" for="forrent">
                                    Not yet paid
                                </label>
                            </div>
                            <div class="form-check">
                                <input 
                                    id="forsale" name="paid" type="radio"
                                    class="form-check-input" value="true" 
                                />
                                <label class="form-check-label text-uppercase" for="forsale">
                                    Already paid
                                </label>
                            </div>
                        </div>
                        <input type="hidden" name="provider_id" id="provider_id"
                        class="form-control" value="{{ $invoice->provider_id }}" required />
                        <input type="hidden" name="receiver_id" id="receiver_id"
                        class="form-control" value="{{ $invoice->receiver_id }}" required />
                        <input type="hidden" name="contract_id[]" id="contract_id"
                        class="form-control" value="{{ $invoice->contract_id[0] }}" required />
                        <button type="submit" class="btn btn-primary">
                            Edit Invoice
                        </button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
