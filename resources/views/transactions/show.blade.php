@extends('layouts.app')

@section('content')




<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('transaction.index') }}">My Transactions</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('transaction.show', $transaction->_id) }}">
                    View Transaction: 
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
            <span class="d-none d-sm-block d-md-none"><hr /></span>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">View Transaction</div>
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
                        <li class="list-group-item">
                            <a class="nounderline" 
                            href="{{ url()->previous() }}">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-arrow-circle-left fa-fw"></i> 
                                    Previous page
                                </button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@php

if (empty($transaction)) { $property = null; }

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
