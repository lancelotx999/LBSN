import React, { Component } from 'react'
import ReactDOM from 'react-dom'

import L from 'leaflet'
import { Map as LeafletMap, Marker, Popup, TileLayer } from 'react-leaflet'

const mapStyle = {
    width: "100%",
    height: "400px"
}

export default class registerLocation extends Component {
    componentDidMount() {
        // create map
        this.map = L.map('map', {
            center: [49.8419, 24.0315],
            zoom: 16,
            layers: [
                L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                }),
            ]
        })

        // add layer
        this.layer = L.layerGroup().addTo(this.map);

        // method called here
        this.updateMarkers(this.props.markersData);
    }

    componentDidUpdate({ markerPosition }) {
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

    // example leaflet function
    updateMarkers(markersData) {
        // Do something...
    }

    constructor(props) {
        super(props);
        this.state = {
            locationOwnerIDInput: '',
            locationNameInput: '',
            locationAddressInput: '',
            locationDescriptionInput: '',
            locationStatusInput: '',
            locationRatingInput: '',
            locationLatitudeInput: '',
            locationLongitudeInput: ''
        };
        // bind
        this.handleChange = this.handleChange.bind(this);
        // bind
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    // handle change
    handleChange(e) {
        // this.setState({
        //     locationOwnerIDInput: e.target.value,
        //     locationNameInput: e.target.value,
        //     locationAddressInput: e.target.value,
        //     locationDescriptionInput: e.target.value,
        //     locationStatusInput: e.target.value,
        //     locationRatingInput: e.target.value,
        //     locationLatitudeInput: e.target.value,
        //     locationLongitudeInput: e.target.value
        // });
        console.log('Name: ', e.target.name);
        console.log('Value: ', e.target.value);

        this.setState({[e.target.name]: e.target.value});
        console.log('onChange', this.state);
    }

    handleSubmit(e) {
        // stop browser's default behaviour of reloading on form submit
        e.preventDefault();
        axios
            .post('/locations', {
                locationOwnerID: this.state.locationOwnerIDInput,
                locationName: this.state.locationNameInput,
                locationAddress: this.state.locationAddressInput,
                locationDescription: this.state.locationDescriptionInput,
                locationStatus: this.state.locationStatusInput,
                locationRating: this.state.locationRatingInput,
                locationLatitude: this.state.locationLatitudeInput,
                locationLongitude: this.state.locationLongitudeInput
            })
            .then(response => {
                console.log('response', response);
                console.log('this.state', this.state);



            });
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Register Location</div>
                            <div className="card-body">
                                <form onSubmit={this.handleSubmit}>
                                    <div id="map" style={mapStyle} />
                                    <hr />
                                    <div className="form-group">
                                        <p>
                                            <label>
                                                Owner ID:
                                                <input
                                                    name="locationOwnerIDInput"
                                                    type="text"
                                                    value={this.state.locationOwnerID}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Create a new location"
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Name:
                                                <input
                                                    name="locationNameInput"
                                                    type="text"
                                                    value={this.state.locationName}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Create a new location"
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Address:
                                                <input
                                                    name="locationAddressInput"
                                                    type="text"
                                                    value={this.state.locationAddress}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Create a new location"
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Description:
                                                <input
                                                    name="locationDescriptionInput"
                                                    type="text"
                                                    value={this.state.locationDescription}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Create a new location"
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Status:
                                                <input
                                                    name="locationStatusInput"
                                                    type="text"
                                                    value={this.state.locationStatus}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Create a new location"
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Rating:
                                                <input
                                                    name="locationRatingInput"
                                                    type="text"
                                                    value={this.state.locationRating}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Create a new location"
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Latitude:
                                                <input
                                                    name="locationLatitudeInput"
                                                    type="text"
                                                    value={this.state.locationLatitude}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Create a new location"
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Longitude:
                                                <input
                                                    name="locationLongitudeInput"
                                                    type="text"
                                                    value={this.state.locationLongitude}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Create a new location"
                                                    required
                                                />
                                            </label>
                                        </p>
                                    </div>
                                    <button type="submit" className="btn btn-primary">
                                        Register Location
                                    </button>
                                </form>
                            </div>
                        </div>



                        <div></div>
                    </div>

                </div>
            </div>
        )
    }
}
