@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register Contract</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('propertyContract.store') }}">
                    	@csrf
                    	@method('POST')

                        <div class="form-group">
                            <p>
                                <label>
                                    Provider:
                                    <input
                                        id="providerID"
                                        name="providerID"
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
                                        name="receiverID"
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
                                        id="locationID"
                                        name="locationID"
                                        type="text"
                                        class="form-control"
                                        value="{{ $location->_id }}"
                                        placeholder="Enter location ID."
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Contract Type:
                                    <input
                                        id="contractType"
                                        name="contractType"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter contract Type."
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Contract Content:
                                    <input
                                        id="contractContent"
                                        name="contractContent"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter contract content."
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Contract Value:
                                    <input
                                        id="contractValue"
                                        name="contractValue"
                                        type="number"
                                        class="form-control"
                                        placeholder="Enter contract value."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Contract Status:
                                    <input
                                        id="contractStatus"
                                        name="contractStatus"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter contract value."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Provider Signature:
                                    <input
                                        id="providerSignature"
                                        name="providerSignature"
                                        type="password"
                                        class="form-control"
                                        placeholder="Enter provider password."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Receiver Signature:
                                    <input
                                        id="receiverSignature"
                                        name="receiverSignature"
                                        type="password"
                                        class="form-control"
                                        placeholder="Enter receiver password."
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
                    @foreach ($contracts as $contract)
	                    <div id="{{ $contract->_id }}" class="media">
			                <div class="media-body">
                                <h5>{{ $contract->contractContent }}</h5>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <a href="{{ route('propertyContract.edit', $contract->_id) }}">
                                            <button class="btn btn-sm btn-success">
                                                Edit
                                            </button>
                                        </a>
                                    </div>

                                    <div class="col-sm-8">
        			                    <form method="POST" action="{{ route('propertyContract.destroy', $contract->_id) }}">
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

<script type="text/javascript">


    var read = "{{ $location }}";
    var json = read.replace(/&quot;/g, '"');
    var location = JSON.parse(json);

    var read = "{{ $contracts }}";
    var json = read.replace(/&quot;/g, '"');
    var contracts = JSON.parse(json);

    // // var location = {!! json_encode($location->toArray()) !!};
    // // var contracts = {!! json_encode($contracts->toArray()) !!};

    console.log("---------- location ----------");
    console.log(location);
    console.log("---------- location ----------");
    console.log("---------- contracts ----------");
    console.log(contracts);
    console.log("---------- contracts ----------");



</script>

@endsection
