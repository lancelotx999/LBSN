@extends('layouts.app')

@section('content')
<div className="container">
    <div className="row justify-content-center">
        <div className="col-md-8">
            <div className="card">
                <div className="card-header">Edit Contract</div>
                <div className="card-body">
                    <form method="POST" action="{{ route('serviceContract.update', $contract) }}">
                    	@csrf
                    	@method('PATCH')

                        <div className="form-group">
                            <p>
                                <label>
                                    Provider:
                                    <input
                                        id="providerID"
                                        name="providerID"
                                        type="text"
                                        value="{{ $contract->providerID }}"
                                        className="form-control"
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
                                        className="form-control"
                                        placeholder="Enter receiver ID."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Property:
                                    <input
                                        id="serviceID"
                                        name="serviceID"
                                        type="text"
                                        value="{{ $contract->serviceID }}"
                                        className="form-control"
                                        placeholder="Enter receiver ID."
                                        required
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
                                        className="form-control"
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
                                        className="form-control"
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
                                        className="form-control"
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
                                        className="form-control"
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
                                        className="form-control"
                                        placeholder="Enter receiver password."
                                    />
                                </label>
                            </p>
                        </div>
                        <button type="submit" className="btn btn-primary">
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
