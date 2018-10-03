import React, { Component } from 'react';
import { Link } from 'react-router-dom';

import L from 'leaflet'
import { Map as LeafletMap, Marker, Popup, TileLayer } from 'react-leaflet'

const mapStyle = {
    width: "100%",
    height: "400px"
}

class editLocation extends Component {
    constructor(props) {
        super(props);
        this.state = {
            // locationOwnerIDInput: '',
            locationNameInput: '',
            locationAddressInput: '',
            locationDescriptionInput: '',
            locationStatusInput: '',
            locationRatingInput: '',
            locationLatitudeInput: '',
            locationLongitudeInput: '',
            locations: []
        };

        // bind
        this.handleChange = this.handleChange.bind(this);
        this.submitLocation = this.submitLocation.bind(this);
    }

    componentWillMount() {
        // this.getLocations();
        this.getLocations();

        // console.log("---------- this.state componentWillMount ----------");
        // console.log(this.state);
        // console.log("---------- this.state componentWillMount ----------");
    }

    componentDidMount() {
        console.log("---------- this.state componentDidMount() ----------");
        console.log(this.state);
        console.log("---------- this.state componentDidMount() ----------");

        // create map
        this.map = L.map('map', {
            center: [1.5510714615890955, 110.34356832504274],
            zoom: 16,
            layers: [
                L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                }),
            ]
        })

        this.map.on('click', function(e){
            // var coord = e.latlng;
            // var lat = coord.lat;
            // var lng = coord.lng;
            // console.log("You clicked the map at latitude: " + lat + " and longitude: " + lng);

            //need to set state
            //this.state()

            document.getElementById('locationLatitudeInput').value = e.latlng.lat;
            document.getElementById('locationLongitudeInput').value = e.latlng.lng;


        });

        // add layer
        this.layer = L.layerGroup().addTo(this.map);

        // method called here
        this.updateMarkers(this.props.markersData);
    }

    componentDidUpdate() {
        console.log("---------- this.state componentDidUpdate() ----------");
        console.log(this.state);
        console.log("---------- this.state componentDidUpdate() ----------");


        // document.getElementById('locationNameInput').value = this.state.locations[0].locationName;
        // document.getElementById('locationAddressInput').value = this.state.locations[0].locationAddress;
        // document.getElementById('locationDescriptionInput').value = this.state.locations[0].locationDescription;
        // document.getElementById('locationStatusInput').value = this.state.locations[0].locationStatus;
        // document.getElementById('locationRatingInput').value = this.state.locations[0].locationRating;
        // document.getElementById('locationLatitudeInput').value = this.state.locations[0].locationLatitude;
        // document.getElementById('locationLongitudeInput').value = this.state.locations[0].locationLongitude;


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
        //     locationOwnerIDInput: e.target.value,
        //     locationNameInput: e.target.value,
        //     locationAddressInput: e.target.value,
        //     locationDescriptionInput: e.target.value,
        //     locationStatusInput: e.target.value,
        //     locationRatingInput: e.target.value,
        //     locationLatitudeInput: e.target.value,
        //     locationLongitudeInput: e.target.value
        // });
        // console.log('Name: ', e.target.name);
        // console.log('Value: ', e.target.value);
        //
        //
        //
        // this.setState({[e.target.name]: e.target.value});
        // console.log('onChange', this.state);
    }

    submitLocation(e) {
        // stop browser's default behaviour of reloading on form submit
        e.preventDefault();
        axios
            .put(`/locations/${this.props.match.params.id}`, {
                locationName: document.getElementById('locationNameInput').value,
                locationAddress: document.getElementById('locationAddressInput').value,
                locationDescription: document.getElementById('locationDescriptionInput').value,
                locationStatus: document.getElementById('locationStatusInput').value,
                locationRating: document.getElementById('locationRatingInput').value,
                locationLatitude: document.getElementById('locationLatitudeInput').value,
                locationLongitude: document.getElementById('locationLongitudeInput').value
            })
            .then(response => {
                console.log('successfully edited the location');
                this.props.history.push('/');
            });

    }

    getLocations() {
        axios.get(`/locations/${this.props.match.params.id}/edit`).then((
            response // console.log(response.data.locations)
        ) =>
            this.setState({
                locationName: response.data.location.locationName,
                locationAddress: response.data.location.locationAddress,
                locationDescription: response.data.location.locationDescription,
                locationStatus: response.data.location.locationStatus,
                locationRating: response.data.location.locationRating,
                locationLatitude: response.data.location.locationLatitude,
                locationLongitude: response.data.location.locationLongitude
            })
        );
    }

    // example leaflet function
    updateMarkers(markersData) {
        // Do something...
    }


    render(){
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Register Location</div>
                            <div className="card-body">
                                <form onSubmit={this.submitLocation}>
                                    <div id="map" style={mapStyle} />
                                    <hr />
                                    <div className="form-group">
                                        <p>
                                            <label>
                                                Name:
                                                <input
                                                    id="locationNameInput"
                                                    name="locationNameInput"
                                                    type="text"
                                                    value={this.state.locationName}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter location name."
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Address:
                                                <input
                                                    id="locationAddressInput"
                                                    name="locationAddressInput"
                                                    type="text"
                                                    value={this.state.locationAddress}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter location address."
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Description:
                                                <input
                                                    id="locationDescriptionInput"
                                                    name="locationDescriptionInput"
                                                    type="text"
                                                    value={this.state.locationDescription}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter location description."
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Status:
                                                <input
                                                    id="locationStatusInput"
                                                    name="locationStatusInput"
                                                    type="text"
                                                    value={this.state.locationStatus}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter location status."
                                                    required
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Rating:
                                                <input
                                                    id="locationRatingInput"
                                                    name="locationRatingInput"
                                                    type="number"
                                                    value={this.state.locationRating}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Enter location rating."
                                                    required
                                                    step="0.01"
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Latitude:
                                                <input
                                                    id="locationLatitudeInput"
                                                    name="locationLatitudeInput"
                                                    type="text"
                                                    value={this.state.locationLatitude}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Click on map to set latitude."
                                                    step="0.0"
                                                    required
                                                    readOnly
                                                />
                                            </label>
                                        </p>
                                        <p>
                                            <label>
                                                Longitude:
                                                <input
                                                    id="locationLongitudeInput"
                                                    name="locationLongitudeInput"
                                                    type="text"
                                                    value={this.state.locationLongitude}
                                                    onChange={this.handleChange}
                                                    className="form-control"
                                                    placeholder="Click on map to set longitude."
                                                    step="0.0"
                                                    required
                                                    readOnly
                                                />
                                            </label>
                                        </p>
                                    </div>
                                    <button type="submit" className="btn btn-primary">
                                        Edit Location
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

export default editLocation;
