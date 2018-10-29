@extends('layouts.app')

@section('content')

<div class="container-fluid wrapper">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            
                <div class="row">
                    <div id="sidebar" class="col-sm-3">
                        
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
                        <button id="convert">
                            Get all features to GeoJSON string
                        </button>
                    </div>
                    <div id="map" class="col-sm-9"></div>
                </div> 
                
            
            <!--leaflet popup -->

        </div>
    </div>
</div>

<script type="text/javascript">
    //map presets
	var map = L.map('map', { zoomControl: false  })
        .setView(new L.LatLng(40, -74), 10) //NYC Location
        .addLayer(new L.TileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"));

    //add zoom control with your options
    L.control.zoom({ position:'topright' }).addTo(map);

    map.options.minZoom = 2;

    var southWest = new L.LatLng(-90, 180);
    var northEast = new L.LatLng(90, -180);

    var colors = ['#ff4b00', '#bac900', '#EC1813', '#55BCBE', '#D2204C', '#FF0000', '#ada59a', '#3e647e'],
        pi2 = Math.PI * 2;

    map.setMaxBounds(new L.LatLngBounds(southWest, northEast));

    map.fitBounds(new L.LatLngBounds(southWest, northEast), {reset: true});

    map.setView(new L.LatLng(40.7, -73.8), 10) //NYC Location

    //Adding the edit toolbar/marker
    var drawnItems = L.geoJson().addTo(map);
    map.addControl(new L.Control.Draw({
        draw: {
             polygon: false,
             circle: false,
             rectangle: false,
             polyline: false,
             circlemarker: false
         },
        edit: {
            featureGroup: drawnItems
        }
    }));

    //Defining marker properties and click event
    map.on('draw:created', function (event) {
        var layer = event.layer,
            type = event.layerType,
            feature = layer.feature = layer.feature || {};
        
        feature.type = feature.type || "Feature";
        var props = feature.properties = feature.properties || {};
        props.desc = null;
        props.image = null;
        props.title = null;
    	props.content = null;
        drawnItems.addLayer(layer);
        addPopup(layer);
    });

    
    //popup on marker create
    var estateform = L.popup();
    function addPopup(layer) {
        
        var content = '<form role="form" id="form" enctype="multipart/form-data" class = "form-horizontal" onsubmit="addMarker()">'+
          '<div class="form-group">'+
              '<label class="control-label col-sm-5"><strong>Date: </strong></label>'+
              '<input type="date" placeholder="Required" id="date" name="date" class="form-control"/>'+ 
          '</div>'+
          '<div class="form-group">'+
              '<label class="control-label col-sm-5"><strong>Gender: </strong></label>'+
              '<select class="form-control" id="gender" name="gender">'+
                '<option value="Male">Male</option>'+
                '<option value="Female">Female</option>'+
                '<option value="Other">Other</option>'+
              '</select>'+ 
          '</div>'+
          '<div class="form-group">'+
              '<label class="control-label col-sm-5"><strong>Age: </strong></label>'+
              '<input type="number" min="0" class="form-control" id="age" name="age">'+ 
          '</div>'+
          //...
          '<div class="form-group">'+
              '<label class="control-label col-sm-5"><strong>Description: </strong></label>'+
              '<textarea class="form-control" rows="6" id="descrip" name="descript">...</textarea>'+
          '</div>'+
          '<div class="form-group">'+
            '<div style="text-align:center;" class="col-xs-4 col-xs-offset-2"><button type="button" class="btn">Cancel</button></div>'+
            '<div style="text-align:center;" class="col-xs-4"><button type="submit" value="submit" class="btn btn-primary trigger-submit">Submit</button></div>'+
          '</div>'+
          '</form>';
        estateform.setContent(content);
        
        layer.bindPopup(content).openPopup();
        estateform.setLatLng(layer.getLatLng()); 
		estateform.openOn(map);
        // var content = document.createElement("textarea");
        // content.addEventListener("keyup", function () {
        //     layer.feature.properties.desc = content.value;
        // });
        // layer.on("popupopen", function () {
        //     content.value = layer.feature.properties.desc;
        // content.focus();
        // });
        // layer.bindPopup(content).openPopup();
    }

    document.getElementById("convert").addEventListener("click", function () {
        console.log(JSON.stringify(drawnItems.toGeoJSON(), null, 2));
    });
    
</script>
@endsection
