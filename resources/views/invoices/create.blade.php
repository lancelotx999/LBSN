@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Invoice</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('invoice.store') }}">
                    	@csrf
                    	@method('POST')

                        <div class="form-group">
                            <p>
                                <label>
                                    Sender:
                                    <input
                                        id="sender"
                                        name="sender"
                                        type="text"
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
                                        class="form-control"
                                        placeholder="Enter paid."
                                        required
                                    />
                                </label>
                            </p>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Create Invoice
                        </button>
                    </form>
                    <hr />
                    @foreach ($invoices as $invoice)
	                    <div id="{{ $invoice->_id }}" class="media">
			                <div class="media-body">
                                <h5>{{ $invoice->receiver }}'s invoice</h5>
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
			                </div>
			            </div>
		            @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
