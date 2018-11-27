@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.index') }}">My Contracts</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.show', $contract->_id) }}">View Contract: {{ $contract->name }}</a>
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
                <div class="card-header">View Contract</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Name:</strong><br />
                            {{ $contract->name }}
                        </li>
                        <li class="list-group-item text-capitalize">
                            <strong>Contract Type:</strong><br />
                            {{ $contract->type }}
                        </li>
                        <li class="list-group-item">
                            <strong>Description:</strong><br />
                            {{ $contract->description }}
                        </li>
                        <li class="list-group-item">
                            <strong>Price:</strong><br />
                            RM {{ $contract->price }}
                        </li>
                    </ul>
                    <br />
                    <a class="nounderline" 
                    href="{{ url()->previous() }}">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-arrow-circle-left fa-fw"></i> 
                            Previous page
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@php

if (empty($contract)) { $contract = null; }

@endphp

@endsection
