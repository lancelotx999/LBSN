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
                <a href="{{ route('contract.show', $contract->_id) }}">View Contract {{ $contract->item_id }}</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">View Contract</div>
                <div class="card-body">
                    <p>
                        Provider: {{ $contract->provider_id }}
                    </p>
                    <p>
                        Receiver: {{ $contract->receiver_id }}
                    </p>
                    <p>
                        Property: {{ $contract->item_id }}
                    </p>
                    <p>
                        Contract Type: {{ $contract->type }}
                    </p>
                    <p>
                        Description: {{ $contract->description }}
                    </p>
                    <p>
                        Property Price: {{ $contract->price }}
                    </p>
                    <hr />
                    <p><a href="{{ url()->previous() }}">Return to previous page</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@php

if (empty($property)) { $property = null; }

@endphp

@endsection
