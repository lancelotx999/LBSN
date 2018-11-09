@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.index') }}">Contracts</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('contract.create') }}">Create New Contract</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Contract</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('contract.store') }}">
                    	@csrf
                    	@method('POST')

                        <div class="form-group">
                            <label for="provider_id">
                                Provider:
                            </label>
                            <input
                                id="provider_id" name="provider_id" type="text"
                                class="form-control"
                                placeholder="Enter provider ID."
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="receiver_id">
                                Receiver:
                            </label>
                            <input
                                id="receiver_id" name="receiver_id" type="text"
                                class="form-control"
                                placeholder="Enter receiver ID."
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="item_id">
                                Property:
                            </label>
                            <input
                                id="item_id" name="item_id" type="text"
                                class="form-control"
                                placeholder="Enter item ID."
                            />
                        </div>
                        <div class="form-group">
                            <label for="type">
                                Contract Type:
                            </label>
                            <input
                                id="type" name="type" type="text"
                                class="form-control"
                                placeholder="Enter contract type."
                            />
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
                                Property Price:
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
                        <button type="submit" class="btn btn-primary">
                            Create Contract
                        </button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
