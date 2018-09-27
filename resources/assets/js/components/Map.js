import React, { Component } from 'react'
import ReactDOM from 'react-dom'

import L from 'leaflet'
import { Map as LeafletMap, Marker, Popup, TileLayer } from 'react-leaflet'

const mapStyle = {
    width: "100%",
    height: "400px"
}

export default class MapTest extends Component {
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
        // check if position has changed
        if (this.props.markerPosition !== markerPosition) {
            this.marker.setLatLng(this.props.markerPosition);
        }

        // check if data has changed
        if (this.props.markersData !== markersData) {
            this.updateMarkers(this.props.markersData);
        }
    }

    // example leaflet function
    updateMarkers(markersData) {
        // Do something...
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">

                        <div id="map" style={ mapStyle } />

                        <hr />

                        <div></div>

                    </div>
                </div>
            </div>
        )
    }
}
