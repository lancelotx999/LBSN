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
                                            <header class="card-header">
                                                <h6 class="title">Price Range </h6>
                                            </header>
                                            <div class="filter-content">
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Min (MYR)</label>
                                                            <input type="number" class="form-control" id="inputEmail4" placeholder="380,000"/>
                                                        </div>
                                                        <div class="form-group col-md-6 text-right">
                                                            <label>Max (MYR)</label>
                                                            <input type="number" class="form-control" placeholder="450,000"/>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </article> 
                                    	<article class="card-group-item">
                                            <header class="card-header">
                                                <h6 class="title">Floor/Height </h6>
                                            </header>
                                            <div class="filter-content">
                                                <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Min height (feet)</label>
                                                        <input type="number" class="form-control" id="inputEmail4" placeholder="18 ft"/>
                                                    </div>
                                                    <div class="form-group col-md-6 text-right">
                                                        <label>Max height (feet)</label>
                                                        <input type="number" class="form-control" placeholder="33 ft"/>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Floor</label>
                                                        <select class="form-control" id="exampleSelect1">
                                                            <option>1 floor</option>
                                                            <option>2 floors</option>
                                                            <option>2.5 floors</option>
                                                            <option>3 floors</option>
                                                        </select>
                                                    </div>
                                                </div>
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
                                                                <span class="badge badge-light round">142</span>
                                                            </span>
                                                            
				                                        </label> 
				                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                road
                                                                <span class="badge badge-light round">3</span>
                                                            </span>
				                                        </label>  
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                mountain
                                                                <span class="badge badge-light round">16</span>
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                river
                                                                <span class="badge badge-light round">57</span>
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                original
                                                                <span class="badge badge-light round">119</span>
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                forest
                                                                <span class="badge badge-light round">90</span>
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                landscape
                                                                <span class="badge badge-light round">112</span>
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                city
                                                                <span class="badge badge-light round">32</span>
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                suburban
                                                                <span class="badge badge-light round">14</span>
                                                            </span>
				                                        </label> 
                                                        <label class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""/>
                                                            <span class="form-check-label">
                                                                no humans
                                                                <span class="badge badge-light round">66</span>
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

