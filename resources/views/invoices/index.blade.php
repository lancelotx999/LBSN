@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('transaction.index') }}">Properties</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Properties</div>
                <div class="card-body">
                    @if ($received_invoices->isEmpty())
                        <br />
                        <h1 class="display-4">Hello, it seems empty here!</h1>
                        <p class="lead">Why don't you try to add some stuff?</p>
                        <hr />
                    @endif
                    @foreach ($received_invoices as $invoice)
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h5>ID: {{ $invoice->id }}</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <p>Provider: {{ $invoice->provider->name }}</p>
                                </div>
                                <div class="row">
                                    <p>Receiver: {{ $invoice->receiver->name }}</p>
                                </div>
                                <div class="row">
                                    <p>Grand Total: {{ $invoice->grand_total }}</p>
                                </div>
                                <div class="row">
                                    <p>Outstanding Payment: {{ $invoice->outstanding_payment }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="{{ route('invoice.show', $invoice->_id) }}">
                                    <button class="btn btn-sm btn-success">
                                        View
                                    </button>
                                </a>
                                <a href="{{ route('invoice.edit', $invoice->_id) }}">
                                    <button class="btn btn-sm btn-success">
                                        Edit
                                    </button>
                                </a>
                                <a href="/transaction/create/{{ $invoice->_id }}">
                                    <button class="btn btn-sm btn-success">
                                        Pay
                                    </button>
                                </a>
                            </div>

                            <div class="col-sm-8">
                                <form method="POST" action="{{ route('invoice.destroy', $invoice->_id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger float-right">
                                        DELETE
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr />
                    @endforeach
                <a href="{{ route('invoice.create') }}">Create Invoice</a>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">


    var received_invoices = {!! json_encode($received_invoices->toArray()) !!};

    console.log("---------- received_invoices ----------");
    console.log(received_invoices);
    console.log("---------- received_invoices ----------");


</script>
@endsection
