@extends('layouts.app')

@section('content')

<script src="{{ asset('js/leaflet.js') }}"></script>

<div class="container-fluid wrapper">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            
                <div class="row">
                    <div id="sidebar" class="col-sm-12">
                        
                        <div class="card">
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
                                <header class="card-header">
                                    <h6 class="title">Tags</h6>
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
                
            <div id="map"></div>

        </div>
    </div>
</div>

<script type="text/javascript">
	var mymap = L.map('map').setView([51.505, -0.09], 13);

	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18
	}).addTo(mymap);
</script>
@endsection
