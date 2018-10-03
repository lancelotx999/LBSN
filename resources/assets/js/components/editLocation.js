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
            // locationOwnerID: '',
            locationName: '',
            locationAddress: '',
            locationDescription: '',
            locationStatus: '',
            locationRating: '',
            locationLatitude: '',
            locationLongitude: '',
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

        function updateLatLng(state, e){
            // console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
            // console.log(e);
            // console.log(state);
            // console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
            document.getElementById('locationLatitude').value = e.latlng.lat;
            document.getElementById('locationLongitude').value = e.latlng.lng;

            state.setState({
                locationLatitude: e.latlng.lat,
                locationLongitude: e.latlng.lng
            })
        }

        // this.map.on('click', function(e){
        //     // var coord = e.latlng;
        //     // var lat = coord.lat;
        //     // var lng = coord.lng;
        //     // console.log("You clicked the map at latitude: " + lat + " and longitude: " + lng);
        //
        //     //need to set state
        //     //this.state()
        //
        //     document.getElementById('locationLatitude').value = e.latlng.lat;
        //     document.getElementById('locationLongitude').value = e.latlng.lng;
        //
        //     this.setState({
        //         locationLatitude: e.latlng.lat,
        //         locationLongitude: e.latlng.lng
        //     })
        //
        //
        // });

        this.map.on("click", updateLatLng.bind(null, this));

        // add layer
        this.layer = L.layerGroup().addTo(this.map);

        // method called here
        this.updateMarkers(this.props.markersData);
    }

    componentDidUpdate() {
        console.log("---------- this.state componentDidUpdate() ----------");
        console.log(this.state);
        console.log("---------- this.state componentDidUpdate() ----------");


        // document.getElementById('locationName').value = this.state.locations[0].locationName;
        // document.getElementById('locationAddress').value = this.state.locations[0].locationAddress;
        // document.getElementById('locationDescription').value = this.state.locations[0].locationDescription;
        // document.getElementById('locationStatus').value = this.state.locations[0].locationStatus;
        // document.getElementById('locationRating').value = this.state.locations[0].locationRating;
        // document.getElementById('locationLatitude').value = this.state.locations[0].locationLatitude;
        // document.getElementById('locationLongitude').value = this.state.locations[0].locationLongitude;


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

    submitLocation(e) {
        // stop browser's default behaviour of reloading on form submit
        e.preventDefault();
        axios
            .put(`/locations/${this.props.match.params.id}`, {
                locationName: this.state.locationName,
                locationAddress: this.state.locationAddress,
                locationDescription: this.state.locationDescription,
                locationStatus: this.state.locationStatus,
                locationRating: this.state.locationRating,
                locationLatitude: this.state.locationLatitude,
                locationLongitude: this.state.locationLongitude
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
                                                    id="locationName"
                                                    name="locationName"
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
                                                    id="locationAddress"
                                                    name="locationAddress"
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
                                                    id="locationDescription"
                                                    name="locationDescription"
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
                                                    id="locationStatus"
                                                    name="locationStatus"
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
                                                    id="locationRating"
                                                    name="locationRating"
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
                                                    id="locationLatitude"
                                                    name="locationLatitude"
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
                                                    id="locationLongitude"
                                                    name="locationLongitude"
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
