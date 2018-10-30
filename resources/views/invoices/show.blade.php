@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $invoice->receiver }}'s Invoice</div>
                <div class="card-body">
                    <p>
                        Sender: {{ $invoice->sender }}
                    </p>
                    <p>
                        Receiver: {{ $invoice->receiver }}
                    </p>
                    <p>
                        Price amount: RM{{ $invoice->price }}
                    </p>
                    <p>
                        Service: {{ $invoice->service }}
                    </p>
                    <p>
                        Paid amount: RM{{ $invoice->paid }}
                    </p>
                    <a href="{{ route('invoice.index') }}">Go back to previous page</a>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
