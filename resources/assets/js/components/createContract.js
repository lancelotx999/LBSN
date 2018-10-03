import React, { Component } from 'react'
import ReactDOM from 'react-dom'

// import L from 'leaflet'
// import { Map as LeafletMap, Marker, Popup, TileLayer } from 'react-leaflet'
// import { PruneCluster, PruneClusterForLeaflet } from 'exports-loader?PruneCluster,PruneClusterForLeaflet!prunecluster/dist/PruneCluster.js'
import { Link } from 'react-router-dom';

// const mapStyle = {
//     width: "100%",
//     height: "400px"
// }

export default class createContract extends Component {
    constructor(props) {
        super(props);
        this.state = {
            providerIDInput: '',
            receiverIDInput: '',
            contractContentInput: '',
            contractValueInput: '',
            contractStatusInput: '',
            providerSignatureInput: '',
            receiverSignatureInput: '',
            contracts: [],
            users: []
        };

        this.handleChange = this.handleChange.bind(this);

        this.submitContract = this.submitContract.bind(this);

        this.renderContracts = this.renderContracts.bind(this);

        this.deleteContract = this.deleteContract.bind(this);

        this.updateContract = this.updateContract.bind(this);
    }

    componentWillMount() {
        this.getContracts();

        // console.log("---------- this.state componentWillMount ----------");
        // console.log(this.state);
        // console.log("---------- this.state componentWillMount ----------");
    }

    componentDidMount() {
        console.log("---------- this.state componentDidMount() ----------");
        console.log(this.state);
        console.log("---------- this.state componentDidMount() ----------");

    }

    componentDidUpdate() {
        console.log("---------- this.state componentDidUpdate() ----------");
        console.log(this.state);
        console.log("---------- this.state componentDidUpdate() ----------");

    }

    // get all users from backend
    getUsers() {
        axios.get('/users').then((
            response // console.log(response.data.contracts)
        ) =>
            this.setState({
                contracts: [...response.data.contracts]
            })
        );
    }

    submitContract(e) {
        // stop browser's default behaviour of reloading on form submit
        e.preventDefault();
        axios.post('/contracts', {
                // contractOwnerID: this.state.contractOwnerIDInput,
                providerID: document.getElementById('providerIDInput').value,
                receiverID: document.getElementById('receiverIDInput').value,
                contractContent: document.getElementById('contractContentInput').value,
                contractValue: document.getElementById('contractValueInput').value,
                contractStatus: document.getElementById('contractStatusInput').value,
                providerSignature: document.getElementById('providerSignatureInput').value,
                receiverSignature: document.getElementById('receiverSignatureInput').value
            })
            .then(response => {

                this.setState({
                    contracts: [response.data, ...this.state.contracts]
                });

                console.log('response', response);
                console.log('this.state', this.state);
            });


    }

    // get all contracts from backend
    getContracts() {
        axios.get('/contracts').then((
            response // console.log(response.data.contracts)
        ) =>
            this.setState({
                contracts: [...response.data.contracts]
            })
        );
    }

    deleteContract(id) {
        // remove from local state
        const isNotId = contract => contract._id !== id;
        const updatedContracts = this.state.contracts.filter(isNotId);

        this.setState({ contracts: updatedContracts });


        // make delete request to the backend
        axios.delete(`/contracts/${id}`);

    }

    updateContract(){
        axios.put(`/${id}/editContract`).then(response => {
            this.getContracts();
        });
    }

    // example leaflet function
    updateMarkers(markersData) {
        // Do something...
    }

    // handle change
    handleChange(e) {
        // this.setState({
        //     providerIDInput: e.target.value,
        //     receiverIDInput: e.target.value,
        //     contractContentInput: e.target.value,
        //     contractValueInput: e.target.value,
        //     contractStatusInput: e.target.value,
        //     providerSignatureInput: e.target.value,
        //     receiverSignatureInput: e.target.value
        // });
        // console.log('Name: ', e.target.name);
        // console.log('Value: ', e.target.value);
        //
        // this.setState({[e.target.name]: e.target.value});
        // console.log('onChange', this.state);
    }



    // render contracts
    renderContracts() {
        // console.log("---------- this.state.contracts ----------");
        // console.log(this.state.contracts);
        // console.log("---------- this.state.contracts ----------");

        // this.state.contracts.forEach(function (d){
        //     console.log(d);
        //
        //     html += "<div key="+ d._id + " className='media'><div className='media-body'><p>" + d.contractName + "</p></div></div> </br>";
        //     console.log(html);
        // })
        //
        // return html;

        console.log("---------- this.state.contracts ----------");
        console.log(this.state.contracts);
        console.log("---------- this.state.contracts ----------");

        return this.state.contracts.map(contract => (
            <div key={contract._id} className="media">
                <div className="media-body">
                    <p>{contract.contractContent}</p>
                    <button onClick={() => this.deleteContract(contract._id)}className="btn btn-sm btn-warning float-right">
                        Delete
                    </button>
                    <Link className="btn btn-sm btn-success" to={`/${contract._id}/editContract`}>
                        Edit
                    </Link>
                </div>
            </div>
        ));
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Register Contract</div>
                            <div className="card-body">
                                <form onSubmit={this.submitContract}>
                                    <div className="form-group">
                                        <p>
                                            <label>
                                                Provider:
                                                <input
                                                    id="providerIDInput"
                                                    name="providerIDInput"
                                                    type="text"
                                                    value={this.state.providerID}
                                                    onChange={this.handleChange}
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
                                                    id="receiverIDInput"
                                                    name="receiverIDInput"
                                                    type="text"
                                                    value={this.state.receiverID}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter receiver ID."
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Content:
                                                <input
                                                    id="contractContentInput"
                                                    name="contractContentInput"
                                                    type="text"
                                                    value={this.state.contractContent}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter contract content."
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Contract Value:
                                                <input
                                                    id="contractValueInput"
                                                    name="contractValueInput"
                                                    type="number"
                                                    value={this.state.contractValue}
                                                    onChange={this.handleChange}
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
                                                    id="contractStatusInput"
                                                    name="contractStatusInput"
                                                    type="text"
                                                    value={this.state.contractStatus}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter contract value."
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Provider Signature:
                                                <input
                                                    id="providerSignatureInput"
                                                    name="providerSignatureInput"
                                                    type="password"
                                                    value={this.state.providerSignature}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter provider password."
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Receiver Signature:
                                                <input
                                                    id="receiverSignatureInput"
                                                    name="receiverSignatureInput"
                                                    type="password"
                                                    value={this.state.receiverSignature}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter receiver password."
                                                    required
                                                />
                                            </label>
                                        </p>
                                    </div>
                                    <button type="submit" className="btn btn-primary">
                                        Create Contract
                                    </button>
                                </form>
                                <hr />
                                {this.renderContracts()}
                            </div>
                        </div>
                        <div></div>
                    </div>

                </div>
            </div>
        )
    }
}
