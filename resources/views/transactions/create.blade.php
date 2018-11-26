@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('invoice.index') }}">My Invoices</a>
                @if (strpos(url()->previous(), 'invoice'))
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('invoice.show', $invoice->_id) }}">
                    View Invoice: {{ App\Contract::find($invoice->contract_id)[0]->name }}
                </a>
                @endif
                <i class="fas fa-angle-right"></i>
                <a href="{{ url()->current() }}">Create New Transaction</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Transaction For:</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transaction.store') }}">
                    	@csrf
                    	@method('POST')

                        <h4>Invoice: {{ App\Contract::find($invoice->contract_id)[0]->name }}</h4>
                        <hr />
                        <p class="lead">Receiver is {{ $invoice->receiver->name }}.</p>
                        <div class="form-group">
                            <table class="table table-bordered table-dark table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-uppercase">Service</th>
                                        <th class="text-uppercase">Description</th>
                                        <th class="text-uppercase">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoice->contracts as $contract)
                                    <tr>
                                        <td class="text-capitalize bg-light text-dark">
                                            {{ $contract->type }}
                                        </td>
                                        <td class="bg-light text-dark">
                                            {{ $contract->description }}
                                        </td>
                                        <td class="bg-light text-dark">
                                            RM {{ $contract->price }}
                                        </td>
                                    </tr>
                		            @endforeach
                                    <tr>
                                        <th colspan="2" class="text-uppercase">
                                            Subtotal
                                        </th>
                                        <td class="bg-light text-dark">
                                            RM {{ $invoice->total_price }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-uppercase">
                                            Tax 25%
                                        </th>
                                        <td class="bg-light text-dark">
                                            RM {{ $invoice->tax }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-uppercase">
                                            Grand Total
                                        </th>
                                        <td class="bg-light text-dark">
                                            RM {{$invoice->grand_total}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-uppercase">
                                            Outstanding
                                        </th>
                                        <td class="bg-light text-dark">
                                            RM {{$invoice->outstanding_payment}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr />
                            <div class="form-group">
                                <label>
                                    Payment Method:
                                </label>
                                <div class="form-check">
                                    <input 
                                        id="forrent" name="payment_method" type="radio"
                                        class="form-check-input" value="cash" 
                                        checked 
                                    />
                                    <label class="form-check-label" for="forrent">
                                        Cash
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input 
                                        id="forsale" name="payment_method" type="radio"
                                        class="form-check-input" value="card" 
                                    />
                                    <label class="form-check-label" for="forsale">
                                        ePayment
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="amount_paid">
                                    Amount Paid:
                                </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                        <span class="input-group-text">RM</span>
                                    </div>
                                    <input 
                                        id="amount_paid" name="amount_paid" type="number" 
                                        class="form-control" 
                                        placeholder="Enter the amount to be paid."
                                        step="0.01" min="0" required
                                    />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="provider_acknowledgement">
                                    Provider Acknowledment:
                                </label>
                                <input
                                    id="provider_acknowledgement" name="provider_acknowledgement"
                                    type="password" class="form-control"
                                    placeholder="Enter Provider Password." required
                                />
                            </div>
                            <div class="form-group">
                                <label for="receiver_acknowledgement">
                                    Receiver Acknowledment:
                                </label>
                                <input
                                    id="receiver_acknowledgement" name="receiver_acknowledgement"
                                    type="password" class="form-control"
                                    placeholder="Enter Receiver Password." required
                                />
                            </div>
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
                            Send Transaction
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
