@extends('layouts.app')

@section('content')

<script src="{{ asset('js/leaflet.js') }}"></script>
<script src="{{ asset('js/PruneCluster.js') }}"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('transaction.index') }}">My Transactions</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('transaction.edit', $transaction->_id) }}">
                    Edit Transaction: 
                    {{ App\Contract::find($transaction->invoice->contract_id)[0]->name }}
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
                class="list-group-item list-group-item-action">
                    My Invoices
                </a>
                <a href="{{ route('transaction.index') }}" 
                class="list-group-item list-group-item-action active">
                    My Transactions
                </a>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Edit Transaction</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Provider:</strong><br />
                            {{ $transaction->provider->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Receiver:</strong><br />
                            {{ $transaction->receiver->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Payment Method:</strong><br />
                            <span class="text-capitalize">
                                {{ $transaction->payment_method }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <strong>Amount Paid:</strong><br />
                            {{ $transaction->amount_paid }}
                        </li>
                        <li class="list-group-item">
                            <strong>Status:</strong><br />
                            @if ($transaction->acknowledged)
                                Verified
                            @else
                                Unverified
                            @endif
                        </li>
                    </ul>
                    <br />
                    <form method="POST" action="{{ route('transaction.update', $transaction) }}">
                    	@csrf
                    	@method('PATCH')

                        @if (Auth::user()->id == $transaction->provider_id)
                            <div class="form-group">
                                <label for="provider_acknowledgement">
                                    Provider Acknowledment:
                                </label>
                                <input
                                    id="provider_acknowledgement" name="provider_acknowledgement"
                                    type="password" class="form-control"
                                    placeholder="Enter Provider Password"
                                    value="{{ $transaction->provider_acknowledgement }}"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="receiver_acknowledgement">
                                    Receiver Acknowledment:
                                </label>
                                <input
                                    id="receiver_acknowledgement" name="receiver_acknowledgement"
                                    type="password" class="form-control"
                                    placeholder="Enter Receiver Password"
                                    value="{{ $transaction->receiver_acknowledgement }}"
                                    required readOnly
                                />
                            </div>
                        @elseif (Auth::user()->id == $transaction->receiver_id)
                        <div class="form-group">
                            <label for="provider_acknowledgement">
                                Provider Acknowledment:
                            </label>
                            <input
                                id="provider_acknowledgement" name="provider_acknowledgement"
                                type="password" class="form-control"
                                placeholder="Enter Provider Password"
                                value="{{ $transaction->provider_acknowledgement }}"
                                required readOnly
                            />
                        </div>
                        <div class="form-group">
                            <label for="receiver_acknowledgement">
                                Receiver Acknowledment:
                            </label>
                            <input
                                id="receiver_acknowledgement" name="receiver_acknowledgement"
                                type="password" class="form-control"
                                placeholder="Enter Receiver Password"
                                value="{{ $transaction->receiver_acknowledgement }}"
                                required
                            />
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            Edit Transaction
                        </button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>

@php

if (empty($transaction)) { $transaction = null; }

@endphp

<script type="text/javascript">

    var read = "{{ $transaction }}";
    var json = read.replace(/&quot;/g, '"');
    var data = JSON.parse(json);

    console.log("---------- data ----------");
    console.log(data);
    console.log("---------- data ----------");

</script>
@endsection
