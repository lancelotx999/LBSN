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
                <a href="{{ route('property.index') }}">Properties</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('property.edit', $transaction->_id) }}">Edit {{ $transaction->name }}</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Property</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transaction.update', $transaction) }}">
                    	@csrf
                    	@method('PATCH')

                        <div class="form-group">
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
                            @if (Auth::user()->id == $transaction->provider_id)
                                <p>
                                    <label>
                                        Provider Acknowledment:
                                        <input
                                            id="provider_acknowledgement"
                                            name="provider_acknowledgement"
                                            type="password"
                                            class="form-control"
                                            placeholder="Enter Provider Password"
                                            value="{{ $transaction->provider_acknowledgement }}"
                                            required
                                        />
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        Receiver Acknowledment:
                                        <input
                                            id="receiver_acknowledgement"
                                            name="receiver_acknowledgement"
                                            type="password"
                                            class="form-control"
                                            placeholder="Enter Receiver Password"
                                            value="{{ $transaction->receiver_acknowledgement }}"
                                            required
                                            readOnly
                                        />
                                    </label>
                                </p>
                            @elseif (Auth::user()->id == $transaction->receiver_id)
                            <p>
                                <label>
                                    Provider Acknowledment:
                                    <input
                                        id="provider_acknowledgement"
                                        name="provider_acknowledgement"
                                        type="password"
                                        class="form-control"
                                        placeholder="Enter Provider Password"
                                        value="{{ $transaction->provider_acknowledgement }}"
                                        required
                                        readOnly
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Receiver Acknowledment:
                                    <input
                                        id="receiver_acknowledgement"
                                        name="receiver_acknowledgement"
                                        type="password"
                                        class="form-control"
                                        placeholder="Enter Receiver Password"
                                        value="{{ $transaction->receiver_acknowledgement }}"
                                        required
                                    />
                                </label>
                            </p>
                            @endif

                        </div>
                        <button type="submit" class="btn btn-primary">
                            Submit
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
