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

export default class createServiceContract extends Component {
    constructor(props) {
        super(props);
        this.state = {
            providerID: '',
            receiverID: '',
            serviceID: '',
            contractContent: '',
            contractValue: '',
            contractStatus: '',
            providerSignature: '',
            receiverSignature: '',
            propertyContract: [],
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

    // handle change
    handleChange(e) {
        // this.setState({
        //     providerID: e.target.value,
        //     receiverID: e.target.value,
        //     contractContent: e.target.value,
        //     contractValue: e.target.value,
        //     contractStatus: e.target.value,
        //     providerSignature: e.target.value,
        //     receiverSignature: e.target.value
        // });
        // console.log('Name: ', e.target.name);
        // console.log('Value: ', e.target.value);
        //
        this.setState({[e.target.name]: e.target.value});
        // console.log('onChange', this.state);
    }

    // // get all users from backend
    // getUsers() {
    //     axios.get('/propertyContract').then((
    //         response // console.log(response.data.propertyContract)
    //     ) =>
    //         this.setState({
    //             users: [...response.data.users]
    //         })
    //     );
    // }

    submitContract(e) {
        console.log("---------- this.state submitContract----------");
        console.log(this.state);
        console.log("---------- this.state submitContract----------");
        // stop browser's default behaviour of reloading on form submit
        e.preventDefault();
        // axios.post('/propertyContract', {
        //         // contractOwnerID: this.state.contractOwnerID,
        //         providerID: document.getElementById('providerID').value,
        //         receiverID: document.getElementById('receiverID').value,
        //         serviceID: document.getElementById('serviceID').value,
        //         contractContent: document.getElementById('contractContent').value,
        //         contractValue: document.getElementById('contractValue').value,
        //         contractStatus: document.getElementById('contractStatus').value,
        //         providerSignature: document.getElementById('providerSignature').value,
        //         receiverSignature: document.getElementById('receiverSignature').value
        //     })
        //     .then(response => {
        //
        //         this.setState({
        //             propertyContract: [response.data, ...this.state.propertyContract]
        //         });
        //
        //         console.log('response', response);
        //         console.log('this.state', this.state);
        //     });

        axios.post('/propertyContract', {
                // contractOwnerID: this.state.contractOwnerID,
                providerID: this.state.providerID,
                receiverID: this.state.receiverID,
                serviceID: this.state.serviceID,
                contractContent: this.state.contractContent,
                contractValue: this.state.contractValue,
                contractStatus: this.state.contractStatus,
                providerSignature: this.state.providerSignature,
                receiverSignature: this.state.receiverSignature
            })
            .then(response => {

                this.setState({
                    propertyContract: [response.data, ...this.state.propertyContract]
                });

                console.log('response', response);
                console.log('this.state', this.state);
            });


    }

    // get all propertyContract from backend
    getContracts() {
        axios.get('/propertyContract').then((
            response // console.log(response.data.propertyContract)
        ) =>
            this.setState({
                propertyContract: [...response.data.propertyContract],
                users: [...response.data.users]
            })
        );
    }

    deleteContract(id) {
        // remove from local state
        const isNotId = contract => contract._id !== id;
        const updatedContracts = this.state.propertyContract.filter(isNotId);

        this.setState({ propertyContract: updatedContracts });


        // make delete request to the backend
        axios.delete(`/propertyContract/${id}`);

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





    // render propertyContract
    renderContracts() {
        // console.log("---------- this.state.propertyContract ----------");
        // console.log(this.state.propertyContract);
        // console.log("---------- this.state.propertyContract ----------");

        // this.state.propertyContract.forEach(function (d){
        //     console.log(d);
        //
        //     html += "<div key="+ d._id + " className='media'><div className='media-body'><p>" + d.contractName + "</p></div></div> </br>";
        //     console.log(html);
        // })
        //
        // return html;

        // console.log("---------- this.state.propertyContract ----------");
        // console.log(this.state.propertyContract);
        // console.log("---------- this.state.propertyContract ----------");

        return this.state.propertyContract.map(contract => (
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
                                                    id="providerID"
                                                    name="providerID"
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
                                                    id="receiverID"
                                                    name="receiverID"
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
                                                Property:
                                                <input
                                                    id="serviceID"
                                                    name="serviceID"
                                                    type="text"
                                                    value={this.state.serviceID}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter contract content."
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
                                                    value={this.state.contractType}
                                                    onChange={this.handleChange}
                                                    className="form-control"
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
                                                    id="contractValue"
                                                    name="contractValue"
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
                                                    id="contractStatus"
                                                    name="contractStatus"
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
                                                    id="providerSignature"
                                                    name="providerSignature"
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
                                                    id="receiverSignature"
                                                    name="receiverSignature"
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
