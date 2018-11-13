@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('invoice.index') }}">My Invoices</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('invoice.show', $invoice->_id) }}">View Invoice: </a>
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
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">View Invoice</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Name:</strong><br />
                            {{ $invoice }}
                        </li>
                        <li class="list-group-item">
                            <strong>Total Price:</strong><br />
                            {{ $invoice->total_price }} MYR
                        </li>
                        <li class="list-group-item">
                            <strong>Tax Price:</strong><br />
                            {{ $invoice->tax }} MYR
                        </li>
                        <li class="list-group-item">
                            <strong>Grand Total:</strong><br />
                            {{ $invoice->grand_total }} MYR
                        </li>
                        <li class="list-group-item">
                            <strong>Outstanding Payment:</strong><br />
                            {{ $invoice->outstanding_payment }} MYR
                        </li>
                        <li class="list-group-item">
                            <strong>Payment Status:</strong><br />
                            @if ($invoice->paid)
                                Has already paid
                            @else
                                Not yet to be paid
                            @endif
                        </li>
                        <li class="list-group-item">
                            <a href="{{ url()->previous() }}">
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

if (empty($contract)) { $contract = null; }

@endphp

@endsection
