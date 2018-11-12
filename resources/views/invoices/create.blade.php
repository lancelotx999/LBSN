@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.index') }}">My Contracts</a>
                @if (strpos(url()->previous(), 'contract'))
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.show', $contract->_id) }}">View {{ $contract->name }}</a>
                @endif
                <i class="fas fa-angle-right"></i>
                <a href="{{ url()->current() }}">Create New Invoice</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Invoice For:</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('contract.store') }}">
                    	@csrf
                    	@method('POST')

                        <h4>{{ $contract->name }}</h4>
                        <div class="form-group">
                            <label for="name">
                                Contract Title:
                            </label>
                            <input type="text" name="name" id="name"
                            class="form-control" placeholder="{{ $contract->name }}.." />
                        </div>
                        <div class="form-group">
                            <label>
                                Contract Type:
                            </label>
                            <div class="form-check">
                                <input 
                                    id="forrent" name="type" type="radio"
                                    class="form-check-input" value="rent" 
                                    checked 
                                />
                                <label class="form-check-label" for="forrent">
                                    Rent
                                </label>
                            </div>
                            <div class="form-check">
                                <input 
                                    id="forsale" name="type" type="radio"
                                    class="form-check-input" value="sell" 
                                />
                                <label class="form-check-label" for="forsale">
                                    Sale
                                </label>
                            </div>
                            <div class="form-check">
                                <input 
                                    id="forservice" name="type" type="radio"
                                    class="form-check-input" value="service" 
                                />
                                <label class="form-check-label" for="forservice">
                                    Service
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">
                                Description:
                            </label>
                            <textarea 
                                id="description" name="description"
                                class="form-control" rows="3"
                                placeholder="Enter description."
                                ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">
                                Price:
                            </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                    <span class="input-group-text">MYR</span>
                                </div>
                                <input 
                                    id="price" name="price" type="text" 
                                    class="form-control" 
                                    placeholder="Enter price value."
                                    required
                                />
                            </div>
                        </div>
                        <input
                            id="provider_id" name="provider_id" type="hidden"
                            class="form-control"
                            placeholder="Enter provider ID."
                            value="{{ Auth::id() }}"
                            required
                        />
                        <button type="submit" class="btn btn-primary">
                            Send Invoice
                        </button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
