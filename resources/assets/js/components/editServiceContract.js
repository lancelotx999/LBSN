import React, { Component } from 'react';
import { Link } from 'react-router-dom';

// import L from 'leaflet'
// import { Map as LeafletMap, Marker, Popup, TileLayer } from 'react-leaflet'

// const mapStyle = {
//     width: "100%",
//     height: "400px"
// }

class editServiceContract extends Component {
    constructor(props) {
        super(props);
        this.state = {
            providerID: '',
            receiverID: '',
            serviceID: '',
            contractType: '',
            contractContent: '',
            contractValue: '',
            contractStatus: '',
            providerSignature: '',
            receiverSignature: '',
            serviceContract: []
        };

        // bind
        this.handleChange = this.handleChange.bind(this);
        this.submitContract = this.submitContract.bind(this);
    }

    componentWillMount() {
        // this.getContracts();
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

        // document.getElementById('providerID').value = this.state.serviceContract[0].providerID;
        // document.getElementById('receiverID').value = this.state.serviceContract[0].receiverID;
        // document.getElementById('contractContent').value = this.state.serviceContract[0].contractContent;
        // document.getElementById('contractValue').value = this.state.serviceContract[0].contractValue;
        // document.getElementById('contractStatus').value = this.state.serviceContract[0].contractStatus;
        // document.getElementById('providerSignature').value = this.state.serviceContract[0].providerSignature;
        // document.getElementById('receiverSignature').value = this.state.serviceContract[0].receiverSignature;

        // // check if position has changed
        // if (this.props.markerPosition !== markerPosition) {
        //     this.marker.setLatLng(this.props.markerPosition);
        // }
        //
        // // check if data has changed
        // if (this.props.markersData !== markersData) {
        //     this.updateMarkers(this.props.markersData);
        // }
    }


    // handle change
    handleChange(e) {
        // this.setState({
        //     locationOwnerID: e.target.value,
        //     locationName: e.target.value,
        //     locationAddress: e.target.value,
        //     locationDescription: e.target.value,
        //     locationStatus: e.target.value,
        //     locationRating: e.target.value,
        //     locationLatitude: e.target.value,
        //     locationLongitude: e.target.value
        // });
        // console.log('Name: ', e.target.name);
        // console.log('Value: ', e.target.value);
        //
        //
        //
        this.setState({[e.target.name]: e.target.value});
        // console.log('onChange', this.state);
    }

    submitContract(e) {
        // stop browser's default behaviour of reloading on form submit
        e.preventDefault();
        axios
            .put(`/serviceContract/${this.props.match.params.id}`, {
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
                console.log('successfully edited the contract');
                this.props.history.push('/');
            });

    }

    // // get all serviceContract from backend
    // getContracts() {
    //     axios.get('/serviceContract').then((
    //         response // console.log(response.data.serviceContract)
    //     ) =>
    //         this.setState({
    //             serviceContract: [...response.data.serviceContract]
    //         })
    //     );
    //
    //
    // }

    getContracts() {
        axios.get(`/serviceContract/${this.props.match.params.id}/edit`).then((
            response
        ) =>
            this.setState({
                providerID: response.data.contract.providerID,
                receiverID: response.data.contract.receiverID,
                serviceID: response.data.contract.serviceID,
                contractContent: response.data.contract.contractContent,
                contractValue: response.data.contract.contractValue,
                contractStatus: response.data.contract.contractStatus,
                providerSignature: response.data.contract.providerSignature,
                receiverSignature: response.data.contract.receiverSignature


            })
        );
    }

    render(){
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
                                                    type="text"
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
                                                    value={this.state.providerSignature}
                                                    onChange={this.handleChange}
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
                                                    value={this.state.receiverSignature}
                                                    onChange={this.handleChange}
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
                        <div></div>
                    </div>

                </div>
            </div>
        )
    }

}

export default editServiceContract;
