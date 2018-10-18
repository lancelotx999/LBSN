@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Contract</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('propertyContract.update', $contract) }}">
                    	@csrf
                    	@method('PATCH')

                        <div class="form-group">
                            <p>
                                <label>
                                    Provider:
                                    <input
                                        id="providerID"
                                        name="providerID"
                                        type="text"
                                        value="{{ $contract->providerID }}"
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
                                        value="{{ $contract->receiverID }}"
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
                                        value="{{ $contract->locationID }}"
                                        class="form-control"
                                        placeholder="Enter receiver ID."
                                        required
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
                                        value="{{ $contract->contractType }}"
                                        class="form-control"
                                        placeholder="Enter contract content."
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
                                        value="{{ $contract->contractContent }}"
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
                                        type="text"
                                        value="{{ $contract->contractValue }}"
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
                                        value="{{ $contract->contractStatus }}"
                                        class="form-control"
                                        placeholder="Select contract status."
                                        required
                                        step="0.01"
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
                                    />
                                </label>
                            </p>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Edit Contract
                        </button>
                    </form>
                    <hr />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
