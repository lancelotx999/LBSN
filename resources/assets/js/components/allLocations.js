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

export default class allLocations extends Component {
    constructor(props) {
        super(props);
        this.state = {
            locations: []
        };

        // this.handleChange = this.handleChange.bind(this);

        // this.submitLocation = this.submitLocation.bind(this);

        this.renderLocations = this.renderLocations.bind(this);

        // this.deleteLocation = this.deleteLocation.bind(this);

        this.updateLocation = this.updateLocation.bind(this);
    }

    componentWillMount() {
        // this.getLocations();
        // this.getLocation();
        this.getAllLocations();

        console.log("---------- this.state componentWillMount ----------");
        console.log(this.state);
        console.log("---------- this.state componentWillMount ----------");
    }

    componentDidMount() {
        console.log("---------- this.state componentDidMount() ----------");
        console.log(this.state);
        console.log("---------- this.state componentDidMount() ----------");

        // create map
        this.map = L.map('map', {
            center: [1.0, 110.0],
            zoom: 16,
            layers: [
                L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                }),
            ]
        })

        // MapClick.on('click', L.bind(onMapClick, null, ID))
        // var testBed = this

        function updateLatLng(state, e){
            // console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
            // console.log(e);
            // console.log(state);
            // console.log("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
            document.getElementById('locationLatitude').value = e.latlng.lat;
            document.getElementById('locationLongitude').value = e.latlng.lng;

            // state.setState({
            //     locationLatitude: e.latlng.lat,
            //     locationLongitude: e.latlng.lng
            // })
        }


        // this.map.on('click', function(e){
        //
        //     console.log("---------- e componentDidMount() ----------");
        //     console.log(e);
        //     console.log("---------- e componentDidMount() ----------");
        //     // var coord = e.latlng;
        //     // var lat = coord.lat;
        //     // var lng = coord.lng;
        //     // console.log("You clicked the map at latitude: " + lat + " and longitude: " + lng);
        //
        //     //need to set state
        //     //this.state()
        //
        //     // document.getElementById('locationLatitude').value = e.latlng.lat;
        //     // document.getElementById('locationLongitude').value = e.latlng.lng;
        //     //
        //     //
        //     // this.setState({
        //     //     locationLatitude: e.latlng.lat,
        //     //     locationLongitude: e.latlng.lng
        //     // })
        //
        //
        // });

        // this.map.on('click', L.bind(updateLatLng, null, this));

        // .on("click", function(e){
        //     updateLatLng(e, );
        // });

        // this.map.on("click", updateLatLng.bind(null, this));

        // add layer
        // this.layer = L.layerGroup().addTo(this.map);

        // method called here
        // this.updateMarkers(this.props.markersData);
    }

    componentDidUpdate() {
        console.log("---------- this.state componentDidUpdate() ----------");
        console.log(this.state);
        console.log("---------- this.state componentDidUpdate() ----------");

        var data = this.state.locations;

        console.log("---------- data ----------");
        console.log(data);
        console.log("---------- data ----------");


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

        data.forEach(function (d){
            // console.log("---------- d ----------");
            // console.log(d);
            // console.log("---------- d ----------");

            var popupContent = "Property Name: " + d.locationName + "</br>" +
                                "Property Address: " + d.locationAddress + "</br>" +
                                "Property Description: " + d.locationDescription + "</br>" +
                                "Property Rating: " + d.locationRating + "</br>" +
                                "Property Status: " + d.locationStatus + "</br>" +
                                "Property Owner Name: " + d.user.name + "</br>" +
                                "Property Owner Email: " + d.user.email + "</br>";

            var marker = new PruneCluster.Marker(d.locationLatitude, d.locationLongitude,{
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
        })

        this.map.addLayer(pruneCluster);

        // var testBed = L.marker([1.5510714615890955, 110.34356832504274]).addTo(this.map)
        //     .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
        //     .openPopup();
        //
        // console.log("---------- testBed ----------");
        // console.log(testBed);
        // console.log("---------- testBed ----------");

        // console.log("---------- this.map ----------");
        // console.log(this.map);
        // console.log("---------- this.map ----------");
        // console.log("---------- pruneCluster ----------");
        // console.log(pruneCluster);
        // console.log("---------- pruneCluster ----------");

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

    // // handle change
    // handleChange(e) {
    //     // this.setState({
    //     //     locationOwnerID: e.target.value,
    //     //     locationName: e.target.value,
    //     //     locationAddress: e.target.value,
    //     //     locationDescription: e.target.value,
    //     //     locationStatus: e.target.value,
    //     //     locationRating: e.target.value,
    //     //     locationLatitude: e.target.value,
    //     //     locationLongitude: e.target.value
    //     // });
    //     // console.log('Name: ', e.target.name);
    //     // console.log('Value: ', e.target.value);
    //     //
    //     // this.setState({[e.target.name]: e.target.value});
    //     // console.log('onChange', this.state);
    // }

    // get all locations from backend
    getLocations() {
        axios.get('/location').then((
            response // console.log(response.data.locations)
        ) =>
            this.setState({
                locations: [...response.data.locations]
            })
        );
    }

    getLocation() {
        axios.get(`/location/${this.props.match.params.id}`).then((
            response // console.log(response.data.locations)
        ) =>
            this.setState({
                location: response.data.location,
            })
        );
    }

    // get all locations from backend
    getAllLocations() {
        axios.get('/allLocations').then((
            response // console.log(response.data.locations)
        ) =>
            this.setState({
                locations: response.data.locations
            })
        );
    }

    // submitLocation(e) {
    //     console.log("---------- this.state submitContract----------");
    //     console.log(this.state);
    //     console.log("---------- this.state submitContract----------");
    //     // stop browser's default behaviour of reloading on form submit
    //     e.preventDefault();
    //     axios.post('/locations', {
    //             // locationOwnerID: this.state.locationOwnerID,
    //             locationName: this.state.locationName,
    //             locationAddress: this.state.locationAddress,
    //             locationDescription: this.state.locationDescription,
    //             locationStatus: this.state.locationStatus,
    //             locationRating: this.state.locationRating,
    //             locationLatitude: this.state.locationLatitude,
    //             locationLongitude: this.state.locationLongitude
    //         })
    //         .then(response => {
    //
    //             this.setState({
    //                 locations: [response.data, ...this.state.locations]
    //             });
    //
    //             console.log('response', response);
    //             console.log('this.state', this.state);
    //         });
    //
    //
    // }

    // // get all locations from backend
    // getLocations() {
    //     axios.get('/allLocations')
    //         .then(response => {
    //             this.setState({
    //                 locations: [...response.data.locations]
    //             })
    //
    //             console.log("---------- this.state getLocations() PRE ----------");
    //             console.log(this.state);
    //             console.log("---------- this.state getLocations() PRE ----------");
    //         })
    //     console.log("---------- this.state getLocations() POST ----------");
    //     console.log(this.state);
    //     console.log("---------- this.state getLocations() POST ----------");
    // }

    deleteLocation(id) {
        // remove from local state
        const isNotId = location => location._id !== id;
        const updatedLocations = this.state.locations.filter(isNotId);

        this.setState({ locations: updatedLocations });


        // make delete request to the backend
        axios.delete(`/location/${id}`);

    }

    updateLocation(){
        axios.put(`/location/${id}`).then(response => {
            this.getLocations();
        });
    }

    // example leaflet function
    updateMarkers(markersData) {
        // Do something...
    }




    // render locations
    renderLocations() {
        console.log("---------- this.state.locations renderLocations()----------");
        console.log(this.state.locations);
        console.log("---------- this.state.locations renderLocations()----------");

        // this.state.locations.forEach(function (d){
        //     console.log(d);
        //
        //     html += "<div key="+ d._id + " className='media'><div className='media-body'><p>" + d.locationName + "</p></div></div> </br>";
        //     console.log(html);
        // })
        //
        // return html;

        return this.state.locations.map(location => (
            <div key={location._id} className="media">
                <div className="media-body">
                    <p>{location.locationName}</p>
                    <Link className="btn btn-sm btn-success" to={`/${location._id}/viewLocation`}>
                        View
                    </Link>
                    <button onClick={() => this.deleteLocation(location._id)}className="btn btn-sm btn-warning float-right">
                        Delete
                    </button>

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
                            <div className="card-header">Register Location</div>
                            <div className="card-body">
                                <div id="map" style={mapStyle} />
                                <hr />
                                {this.renderLocations()}
                            </div>
                        </div>
                        <div></div>
                    </div>

                </div>
            </div>
        )
    }
}
