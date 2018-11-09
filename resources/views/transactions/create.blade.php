@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('property.index') }}">Properties</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('property.create') }}">Create New Property</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Property</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transaction.store') }}">
                    	@csrf
                    	@method('POST')

                        <p>Provider: {{ $invoice->provider->name }}</p>
                        <p>Receiver: {{ $invoice->receiver->name }}</p>

                        <hr />
                        <div class="form-group">
                            <table>
                                <thead>
                                    <tr>
                                        <th class='service'>SERVICE</th>
                                        <th class='desc'>DESCRIPTION</th>
                                        <th>ID</th>
                                        <th>PRICE</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($invoice->contracts as $contract)
                                    <tr>
                                        <td class='service'>{{ $contract->type }}</td>
                                        <td class='desc'>{{ $contract->description }}</td>
                                        <td class='id'>{{ $contract->_id }}</td>
                                        <td class='unit'>{{ $contract->price }}</td>
                                    </tr>
                		            @endforeach
                                    <tr>
                                        <td colspan='3'>SUBTOTAL</td>
                                        <td class='total'>RM{{ $invoice->total_price }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan='3'>TAX 25%</td>
                                        <td id='total' class='total'>RM{{ $invoice->tax }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' class='grand total'>GRAND TOTAL</td>
                                        <td id='grandTotal' class='grand total'>RM{{$invoice->grand_total}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' class='grand total'>OUTSTANDING</td>
                                        <td id='grandTotal' class='grand total'>RM{{$invoice->outstanding_payment}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr />
                            <p>
                                <label>
                                    Payment Method:
                                    <select
                                        id="payment_method"
                                        name="payment_method"
                                        class="form-control custom-select"
                                        required
                                    >
                                        <option selected>Select Payment Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                    </select>
                                </label>
                            </p>
                            <p>
                                <label>
                                    Amount Paid:
                                    <input
                                        id="amount_paid"
                                        name="amount_paid"
                                        type="number"
                                        class="form-control"
                                        placeholder="Enter Amount Paid."
                                        required
                                    />
                                </label>
                            </p>

                            <p>
                                <label>
                                    Provider Acknowledment:
                                    <input
                                        id="provider_acknowledgement"
                                        name="provider_acknowledgement"
                                        type="password"
                                        class="form-control"
                                        placeholder="Enter Provider Password."
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
                                        placeholder="Enter Receiver Password."
                                        required
                                    />
                                </label>
                            </p>
                        </div>
                        <input
                            id="receiver_id"
                            name="receiver_id"
                            type="hidden"
                            class="form-control"
                            value="{{ $invoice->receiver_id }}"
                            placeholder="Enter receiver_id."
                            required
                        />
                        <input
                            id="provider_id"
                            name="provider_id"
                            type="hidden"
                            class="form-control"
                            value="{{ $invoice->provider_id }}"
                            placeholder="Enter provider_id."
                            required
                        />
                        <input
                            id="invoice_id"
                            name="invoice_id"
                            type="hidden"
                            class="form-control"
                            value="{{ $invoice->_id }}"
                            placeholder="Enter invoice_id."
                            required
                        />
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

<script type="text/javascript">

    var read = "{{ $invoice }}";
    var json = read.replace(/&quot;/g, '"');
    var data = JSON.parse(json);
    console.log(data);
</script>
@endsection
