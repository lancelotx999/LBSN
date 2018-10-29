import React, { Component } from 'react'
import ReactDOM from 'react-dom'

import L from 'leaflet'
import { Map as LeafletMap, Marker, Popup, TileLayer } from 'react-leaflet'
import { PruneCluster, PruneClusterForLeaflet } from 'exports-loader?PruneCluster,PruneClusterForLeaflet!prunecluster/dist/PruneCluster.js'
import { Link } from 'react-router-dom';

const mapStyle = {
    width: "100%",
    height: "400px"
}

class editLocation extends Component {
    constructor(props) {
        super(props);

        this.state = {
            // locationOwnerID: '',
            // locationName: '',
            // locationAddress: '',
            // locationDescription: '',
            // locationStatus: '',
            // locationRating: '',
            // locationLatitude: '',
            // locationLongitude: '',
            location: []
        };



        console.log("---------- this.props ----------")
        console.log(this.props)
        console.log("---------- this.props ----------")
        console.log("---------- this.state ----------")
        console.log(this.state)
        console.log("---------- this.state ----------")


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

        var data = this.state.location;
        
        this.map.panTo(new L.LatLng(data.locationLatitude, data.locationLongitude));

        var pruneCluster = new PruneClusterForLeaflet();

        PruneCluster.Cluster.ENABLE_MARKERS_LIST = true;

        pruneCluster.PrepareLeafletMarker = function(leafletMarker, data) {
            // leafletMarker.setIcon(/*... */); // See http://leafletjs.com/reference.html#icon

            // console.log("---------- data PrepareLeafletMarker ----------");
            // console.log(data);
            // console.log("---------- data PrepareLeafletMarker ----------");
            // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
            // console.log(leafletMarker);
            // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
            // console.log("---------- this PrepareLeafletMarker ----------");
            // console.log(this);
            // console.log("---------- this PrepareLeafletMarker ----------");

            //listeners can be applied to markers in this function
            leafletMarker.on('click', function(){
                console.log("---------- data PrepareLeafletMarker ----------");
                console.log(data);
                console.log("---------- data PrepareLeafletMarker ----------");
            });

            // A popup can already be attached to the marker
            // bindPopup can override it, but it's faster to update the content instead
            if (leafletMarker.getPopup()) {
                leafletMarker.setPopupContent(data.popup);
            }
            else {
                leafletMarker.bindPopup(data.popup);
            }

            // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
            // console.log(leafletMarker);
            // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");



        };

        pruneCluster.BuildLeafletCluster = function(cluster, position) {
            var m = new L.Marker(position, {
                icon: pruneCluster.BuildLeafletClusterIcon(cluster)
            });

            m.on('click', function() {
                // Compute the  cluster bounds (it's slow : O(n))
                var markersArea = pruneCluster.Cluster.FindMarkersInArea(cluster.bounds);
                var b = pruneCluster.Cluster.ComputeBounds(markersArea);

                if (b) {
                    var bounds = new L.LatLngBounds(new L.LatLng(b.minLat, b.maxLng),new L.LatLng(b.maxLat, b.minLng));

                    var zoomLevelBefore = pruneCluster._map.getZoom();
                    var zoomLevelAfter = pruneCluster._map.getBoundsZoom(bounds, false, new L.Point(20, 20, null));

                    // If the zoom level doesn't change
                    if (zoomLevelAfter === zoomLevelBefore) {
                        // Send an event for the LeafletSpiderfier
                        pruneCluster._map.fire('overlappingmarkers', {
                            cluster: pruneCluster,
                            markers: markersArea,
                            center: m.getLatLng(),
                            marker: m
                        });

                        pruneCluster._map.setView(position, zoomLevelAfter);
                    }
                    else {
                        pruneCluster._map.fitBounds(bounds);
                    }
                }
            });
            m.on('mouseover', function() {
                //do mouseover stuff here
            });
            m.on('mouseout', function() {
                //do mouseout stuff here
            });

            return m;
        };

        pruneCluster.BuildLeafletClusterIcon = function(cluster) {

            var e = new L.Icon.MarkerCluster();

            e.stats = cluster.stats; // if you have categories on your markers
            e.population = cluster.population; // the number of markers inside the cluster

            var markers = cluster.GetClusterMarkers()

            // console.log("---------- markers ----------");
            // console.log(markers);
            // console.log("---------- markers ----------");

            return e;

        };

        var colors = ['#ff4b00', '#bac900', '#EC1813', '#55BCBE', '#D2204C', '#FF0000', '#ada59a', '#3e647e'],
            pi2 = Math.PI * 2;

        L.Icon.MarkerCluster = L.Icon.extend({
            options: {
                iconSize: new L.Point(44, 44),
                className: 'prunecluster leaflet-markercluster-icon'
            },

            createIcon: function () {
                // based on L.Icon.Canvas from shramov/leaflet-plugins (BSD licence)
                var e = document.createElement('canvas');
                this._setIconStyles(e, 'icon');
                var s = this.options.iconSize;
                e.width = s.x;
                e.height = s.y;
                this.draw(e.getContext('2d'), s.x, s.y);
                return e;
            },

            createShadow: function () {
                return null;
            },

            draw: function(canvas, width, height) {
                var lol = 0;
                var start = 0;
                for (var i = 0, l = colors.length; i < l; ++i) {

                    var size = this.stats[i] / this.population;

                    if (size > 0) {
                        canvas.beginPath();
                        canvas.moveTo(22, 22);
                        canvas.fillStyle = colors[i];
                        var from = start + 0.14,
                        to = start + size * pi2;

                        if (to < from) {
                            from = start;
                        }
                        canvas.arc(22,22,22, from, to);

                        start = start + size*pi2;
                        canvas.lineTo(22,22);
                        canvas.fill();
                        canvas.closePath();
                    }

                }

                canvas.beginPath();
                canvas.fillStyle = 'white';
                canvas.arc(22, 22, 18, 0, Math.PI*2);
                canvas.fill();
                canvas.closePath();

                canvas.fillStyle = '#555';
                canvas.textAlign = 'center';
                canvas.textBaseline = 'middle';
                canvas.font = 'bold 12px sans-serif';

                canvas.fillText(this.population, 22, 22, 40);
            }
        });

        var popupContent = "Property Name: " + data.locationName + "</br>" +
                            "Property Address: " + data.locationAddress + "</br>" +
                            "Property Description: " + data.locationDescription + "</br>" +
                            "Property Rating: " + data.locationRating + "</br>" +
                            "Property Status: " + data.locationStatus + "</br>" +
                            "Property Owner Name: " + data.user.name + "</br>" +
                            "Property Owner Email: " + data.user.email + "</br>";

        var marker = new PruneCluster.Marker(data.locationLatitude, data.locationLongitude,{
            popup: popupContent
        });

        // var marker = new PruneCluster.Marker(d.locationLatitude, d.locationLongitude);

        // var z = document.createElement('p'); // is a node
        // z.innerHTML = 'test satu dua tiga';
        //
        //
        // marker.data.data = d;

        //TODO: this should correlate to location status or location type
        marker.category = 1;

        // console.log("---------- marker ----------");
        // console.log(marker);
        // console.log("---------- marker ----------");

        pruneCluster.RegisterMarker(marker);
        // data.forEach(function (d){
        //     // console.log("---------- d ----------");
        //     // console.log(d);
        //     // console.log("---------- d ----------");
        //
        //
        // })

        this.map.addLayer(pruneCluster);


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
            .put(`/location/${this.props.match.params.id}`, {
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
        axios.get(`/location/${this.props.match.params.id}/edit`).then((
            response // console.log(response.data.locations)
        ) =>
            this.setState({
                location: response.data,
                // locationName: response.data.locationName,
                // locationAddress: response.data.locationAddress,
                // locationDescription: response.data.locationDescription,
                // locationStatus: response.data.locationStatus,
                // locationRating: response.data.locationRating,
                // locationLatitude: response.data.locationLatitude,
                // locationLongitude: response.data.locationLongitude
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
