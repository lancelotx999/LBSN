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
                <div class="card-header">Register Contract</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('contract.store') }}">
                    	@csrf
                    	@method('POST')

                        <div class="form-group">
                            <p>
                                <label>
                                    Provider:
                                    <input
                                        id="providerID"
                                        name="provider_id"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter provider ID."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Receiver:
                                    <input
                                        id="receiverID"
                                        name="receiver_id"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter receiver ID."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Property:
                                    <input
                                        id="itemID"
                                        name="item_id"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter item ID."
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Contract Type:
                                    <input
                                        id="contractType"
                                        name="type"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter contract type."
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Description:
                                </label>
                                <textarea 
                                    class="form-control" 
                                    id="contractContent" 
                                    name="description"
                                    rows="3"
                                    placeholder="Enter description."
                                    >    
                                </textarea>
                            </p>
                            <p>
                                <label>
                                    Property Price:
                                    <input
                                        id="contractValue"
                                        name="price"
                                        type="number"
                                        class="form-control"
                                        placeholder="Enter price value."
                                        required
                                    />
                                </label>
                            </p>
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
