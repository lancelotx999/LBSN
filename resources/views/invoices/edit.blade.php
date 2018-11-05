@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Invoice</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('invoice.update', $invoice) }}">
                    	@csrf
                    	@method('PATCH')

                        <div class="form-group">
                            <p>
                                <label>
                                    Sender:
                                    <input
                                        id="sender"
                                        name="sender"
                                        type="text"
                                        value="{{ $invoice->sender }}"
                                        class="form-control"
                                        placeholder="Enter sender."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Receiver:
                                    <input
                                        id="receiver"
                                        name="receiver"
                                        type="text"
                                        value="{{ $invoice->receiver }}"
                                        class="form-control"
                                        placeholder="Enter receiver."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Price amount:
                                    <input
                                        id="price"
                                        name="price"
                                        type="text"
                                        value="{{ $invoice->price }}"
                                        class="form-control"
                                        placeholder="Enter price."
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Service:
                                    <input
                                        id="service"
                                        name="service"
                                        type="text"
                                        value="{{ $invoice->service }}"
                                        class="form-control"
                                        placeholder="Enter service."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Paid amount:
                                    <input
                                        id="paid"
                                        name="paid"
                                        type="text"
                                        value="{{ $invoice->paid }}"
                                        class="form-control"
                                        placeholder="Enter paid."
                                        required
                                    />
                                </label>
                            </p>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Edit Invoice
                        </button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
