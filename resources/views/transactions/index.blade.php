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
                    @if ($received_transactions->isEmpty())
                        <br />
                        <h1 class="display-4">Hello, it seems empty here!</h1>
                        <p class="lead">Why don't you try to add some stuff?</p>
                        <hr />
                    @endif
                    @foreach ($received_transactions as $transaction)
                        123
                        <!-- <div class="row">
                            <div class="col-sm-3">
                                <img src="https://vignette.wikia.nocookie.net/project-pokemon/images/4/47/Placeholder.png/revision/latest?cb=20170330235552" style="width: 100%">
                                </img>
                            </div>
                            <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>{{ $transaction->name }}</h5>
                                </div>
                                <div class="col-sm-6">
                                    <select id="ratingModule{{ $transaction->id }}" style="float: right;">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <p>{{ $transaction->address }}</p>
                            </div>
                            <div class="row">
                                <p>{{ $transaction->description }}</p>
                            </div>
                            <div class="row">
                                <p>Review(s): ({{ count($transaction->reviews) }})</p>

                            </div>
                        </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <a href="{{ route('transaction.show', $transaction->_id) }}">
                                    <button class="btn btn-sm btn-success">
                                        View
                                    </button>
                                </a>
                                <a href="{{ route('transaction.edit', $transaction->_id) }}">
                                    <button class="btn btn-sm btn-success">
                                        Edit
                                    </button>
                                </a>
                            </div>

                            <div class="col-sm-8">
                                <form method="POST" action="{{ route('transaction.destroy', $transaction->_id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger float-right">
                                        DELETE
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr /> -->
                    @endforeach
                <a href="{{ route('transaction.create') }}">Create Transactions</a>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">


    // var received_transactions = {!! json_encode($received_transactions->toArray()) !!};
    //
    // console.log("---------- received_transactions ----------");
    // console.log(received_transactions);
    // console.log("---------- received_transactions ----------");


</script>
@endsection
