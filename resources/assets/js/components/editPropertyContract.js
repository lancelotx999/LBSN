import React, { Component } from 'react';
import { Link } from 'react-router-dom';

// import L from 'leaflet'
// import { Map as LeafletMap, Marker, Popup, TileLayer } from 'react-leaflet'

// const mapStyle = {
//     width: "100%",
//     height: "400px"
// }

class editPropertyContract extends Component {
    constructor(props) {
        super(props);
        this.state = {
            providerID: '',
            receiverID: '',
            locationID: '',
            contractContent: '',
            contractValue: '',
            contractStatus: '',
            providerSignature: '',
            receiverSignature: '',
            propertyContract: []
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

        // document.getElementById('providerID').value = this.state.propertyContract[0].providerID;
        // document.getElementById('receiverID').value = this.state.propertyContract[0].receiverID;
        // document.getElementById('contractContent').value = this.state.propertyContract[0].contractContent;
        // document.getElementById('contractValue').value = this.state.propertyContract[0].contractValue;
        // document.getElementById('contractStatus').value = this.state.propertyContract[0].contractStatus;
        // document.getElementById('providerSignature').value = this.state.propertyContract[0].providerSignature;
        // document.getElementById('receiverSignature').value = this.state.propertyContract[0].receiverSignature;

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
    
    }

    submitContract(e) {
        // stop browser's default behaviour of reloading on form submit
        e.preventDefault();
        axios
            .put(`/propertyContract/${this.props.match.params.id}`, {
                providerID: this.state.providerID,
                receiverID: this.state.receiverID,
                locationID: this.state.locationID,
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

    // // get all propertyContract from backend
    // getContracts() {
    //     axios.get('/propertyContract').then((
    //         response // console.log(response.data.propertyContract)
    //     ) =>
    //         this.setState({
    //             propertyContract: [...response.data.propertyContract]
    //         })
    //     );
    //
    //
    // }

    getContracts() {
        axios.get(`/propertyContract/${this.props.match.params.id}/edit`).then((
            response
        ) =>
            this.setState({
                providerID: response.data.contract.providerID,
                receiverID: response.data.contract.receiverID,
                locationID: response.data.contract.locationID,
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
                                                    id="locationID"
                                                    name="locationID"
                                                    type="text"
                                                    value={this.state.locationID}
                                                    className="form-control"
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
                                                    value={this.state.contractType}
                                                    className="form-control"
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
                                                    value={this.state.contractContent}
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

export default editPropertyContract;
