import React, { Component } from 'react'
import ReactDOM from 'react-dom'

import L from 'leaflet'
import { Map as LeafletMap, Marker, Popup, TileLayer } from 'react-leaflet'

const style = {
    width: "100%"
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
            
            <div className="container-fluid wrapper">
                <div className="row">
                    <div className="col-xs-12 col-sm-12">
                        
                            <div className="row">
                                <div id="sidebar" className="col-sm-12">
                                    
                                    <div className="card">
                                    <article class="card-group-item">
                                            <header class="card-header">
                                                <h6 class="title">Estate Condition: </h6>
                                            </header>
                                            <div class="filter-content">
                                                <div class="card-body">
                                                <label class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadio" value=""/>
                                                <span class="form-check-label">
                                                    New
                                                </span>
                                                </label>
                                                <label class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadio" value=""/>
                                                <span class="form-check-label">
                                                    Refurbished
                                                </span>
                                                </label>
                                                <label class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadio" value=""/>
                                                <span class="form-check-label">
                                                    Used
                                                </span>
                                                </label>
                                                </div> 
                                            </div>
                                        </article> 
                                        <article class="card-group-item">
                                            <header className="card-header">
                                                <h6 className="title">Tags</h6>
                                            </header>
                                            <div class="filter-content">
			                                    <div class="card-body">
			                                        <form>
				                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                scenery
                                                            </span>
				                                        </label> 
				                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                road
                                                            </span>
				                                        </label>  
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                mountain
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                river
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                original
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                forest
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                landscape
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                city
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                suburban
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                no humans
                                                            </span>
				                                        </label> 
			                                        </form>
			                                    </div> 
		                                    </div>
                                        </article>



                                    </div>
                                </div>
                            </div> 
                            
                        <div id="map" style={ style } />

                        <hr />

                        <div></div>

                    </div>
                </div>
            </div>
        )
    }
}

