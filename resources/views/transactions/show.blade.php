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
                <a href="{{ route('transaction.show', $transaction->_id) }}">View {{ $transaction->name }}</a>
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
                <div class="card-header">View Property</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>ID: {{ $transaction->_id }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <p>Provider: {{ $transaction->provider->name }}</p>
                    </div>
                    <div class="row">
                        <p>Receiver: {{ $transaction->receiver->name }}</p>
                    </div>
                    <div class="row">
                        <p>Payment Method: {{ $transaction->payment_method }}</p>
                    </div>
                    <div class="row">
                        <p>Amount Paid: {{ $transaction->amount_paid }}</p>
                    </div>
                    <div class="row">
                        @if ($transaction->acknowledged == true)
                            <p>Status: Verified</p>
                        @elseif ($transaction->acknowledged == false)
                            <p>Status: Unverified</p>
                        @endif
                    </div>
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
