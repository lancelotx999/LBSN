@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Invoices</div>
                <div class="card-body">
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
                    <a href="{{ route('invoice.create') }}">Create invoices</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
