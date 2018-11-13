@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a> 
                <i class="fas fa-angle-right"></i>
                @if (url()->current() == route('property.index'))
                    <a href="{{ route('property.index') }}">My Properties</a>
                @else
                    <a href="{{ url('/property/listing') }}">Properties</a>
                @endif
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        @if (url()->current() == route('property.index'))
            <div class="col-md-2">
                <div class="card">
                    <div class="list-group">
                        <a href="{{ route('user.index') }}" 
                        class="list-group-item list-group-item-action">
                            My Profile
                        </a>
                        <a href="{{ route('property.index') }}" 
                        class="list-group-item list-group-item-action active">
                            My Properties
                        </a>
                        <a href="{{ route('business.index') }}" 
                        class="list-group-item list-group-item-action">
                            My Businesses
                        </a>
                        <a href="{{ route('contract.index') }}" 
                        class="list-group-item list-group-item-action">
                            My Contracts
                        </a>
                        <a href="{{ route('invoice.index') }}" 
                        class="list-group-item list-group-item-action">
                            My Invoices
                        </a>
                        <a href="{{ route('transaction.index') }}" 
                        class="list-group-item list-group-item-action">
                            My Transactions
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
        @else
            <div class="col-md-12">
        @endif
            <div class="card">
                <div class="card-header">
                    Properties&nbsp;&#8212;
                    <a href="{{ route('property.create') }}">
                        <i class="fas fa-plus-circle fa-fw"></i> Create a new property
                    </a>
                    <hr />
                    <form method="POST" action="{{ route('property.search') }}">
                        @csrf
                        @method('POST')

                        <div class="form-row">
                            <div class="input-group col-md-12 mb-3">
                                <input
                                    id="name" name="name" type="text"
                                    class="form-control"
                                    placeholder="Search.."
                                />
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search fa-fw"></i> Search
                                    </button>
                                </div>
                                <div class="accordion" id="accordionExample">
                                    <button class="btn btn-link" type="button" 
                                    data-toggle="collapse" data-target="#collapseOne" 
                                    aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fas fa-filter fa-fw"></i> Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div 
                            id="collapseOne" class="collapse" 
                            aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="form-row">
                            <div class="col-md-1 mb-3">
                                <label>Status:</label>
                                <div class="form-check">
                                    <input 
                                        id="forrent" name="status" type="checkbox"
                                        class="form-check-input" value="rent"  
                                    />
                                    <label class="form-check-label" for="forrent">
                                        For Rent
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input 
                                        id="forsale" name="status" type="checkbox"
                                        class="form-check-input" value="sell" 
                                    />
                                    <label class="form-check-label" for="forsale">
                                        For Sale
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-1 mb-3">
                                <label>Verified:</label>
                                <div class="form-check">
                                    <input 
                                        id="verified" name="verified" type="checkbox"
                                        class="form-check-input" value="true"  
                                    />
                                    <label class="form-check-label" for="verified">
                                        Yes
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-9 mb-3">
                                <label for="tags">
                                    Tags:
                                </label>
                                <div class="input-group mb-3">
                                    <input
                                        id="tags" name="tags[]" type="text"
                                        class="form-control"
                                        placeholder="Enter an appropriate tag for your property."
                                    />
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="addMore"><i class="fas fa-plus fa-fw"></i></button>
                                    </div>
                                </div>
                                <span id="fieldList"></span>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    @if ($properties->isEmpty())
                    <br />
                    <h3 class="display-4">Hello, it seems empty here!</h3>
                    <p class="lead">Why don't you try to add some stuff?</p>
                    <hr />
                    @endif
                    @foreach ($properties as $property)
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="https://vignette.wikia.nocookie.net/project-pokemon/images/4/47/Placeholder.png/revision/latest?cb=20170330235552" class="img-fluid" alt="Property logo" />
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>
                                        {{ $property->name }}
                                        <span data-toggle="tooltip" data-placement="bottom" 
                                        title="Show location on map">
                                        <button class="btn btn-sm btn-link" 
                                        type="button" data-toggle="modal" 
                                        data-target="#markerModal"
                                        onclick="zoomMarker({{ $property->latitude }}, {{ $property->longitude }})">
                                            <i class="fas fa-location-arrow fa-fw"></i>
                                        </button>
                                        </span>
                                    </h4>
                                    <p>{{ $property->description }}</p>
                                    <hr />
                                    <ul class="list-unstyled">
                                        <li>
                                            <strong>Address:</strong> 
                                            {{ $property->address }}
                                        </li>
                                        <li>
                                            <strong>Review(s):</strong> 
                                            {{ count($property->reviews) }}
                                        </li>
                                        <li>
                                            <select id="ratingModule{{ $property->id }}">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </li>
                                    </ul>
                                    <a href="{{ route('property.show', $property->_id) }}">
                                        <button class="btn btn-sm btn-success">
                                            <i class="fas fa-list fa-fw"></i> View
                                        </button>
                                    </a>
                                    @if ($property->owner_id == Auth::id())
                                    <a href="{{ route('property.edit', $property->_id) }}">
                                        <button class="btn btn-sm btn-success">
                                            <i class="far fa-edit fa-fw"></i> Edit
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-light" data-toggle="modal" 
                                    data-target="#deleteModal{{ $property->_id }}">
                                    <i class="fas fa-times fa-fw"></i> Delete
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="markerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map" style="width: 100%; height: 400px"></div>
            </div>
        </div>
    </div>
</div>

@foreach ($properties as $property)
<div class="modal fade" id="deleteModal{{ $property->_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Deletion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form method="POST" class="form-inline" 
            action="{{ route('property.destroy', $property->_id) }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">
                Delete Now
            </button>
        </form>
    </div>
</div>
</div>
</div>
@endforeach

<script type="text/javascript">
$(function() {
    var maxField = 10; //Input fields increment limitation
    var addButton = $('#addMore'); //Add button selector
    var wrapper = $('#fieldList'); //Input field wrapper
    var fieldHTML = '<div class="input-group mb-3"><input id="tags" name="tags[]" type="text" class="form-control" placeholder="Enter an appropriate tag for your property." /><div class="input-group-append"><button class="btn btn-outline-secondary remove_button" type="button"><i class="fas fa-times fa-fw"></i></button></div></div>'; // The new input
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    addButton.click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            wrapper.append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    wrapper.on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});        
</script>

<script type="text/javascript">

    var read = "{{ $properties }}";
    var json = read.replace(/&quot;/g, '"');
    var properties = JSON.parse(json);

    console.log("---------- properties ----------");
    console.log(properties);
    console.log("---------- properties ----------");

    properties.forEach(function(d){
        console.log("---------- d ----------");
        console.log(d);
        console.log("---------- d ----------");
        console.log('#ratingModule'+d._id);
        $(function() {
            $('#ratingModule'+d._id).barrating({
                theme: 'css-stars',
                initialRating: d.rate,
                readonly: true
            });
        });
    })

    var map = L.map('map', {
        center: [1.5510714615890955, 110.34356832504274],
        zoom: 16,
        layers: [
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }),
        ]
    })

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    // Latitude, Longitude, Zoom
    function zoomMarker(lat, long) {
        map.setView([lat, long], 17)
    }

    $('#markerModal').on('show.bs.modal', function(e){
        setTimeout(function() {
            map.invalidateSize();
        }, 400);
    });

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
    
    properties.forEach(function (d){
        // console.log("---------- d ----------");
        // console.log(d);
        // console.log("---------- d ----------");

        var popupContent = "Property Name: " + d.name + "</br>" +
                           "Property Address: " + d.address + "</br>" +
                           "Property Description: " + d.description + "</br>" +
                           "Property Rating: " + d.rate + "</br>" +
                           "Property Status: " + d.status + "</br>";

        var marker = new PruneCluster.Marker(d.latitude, d.longitude,{
            popup: popupContent
        });


        //TODO: this should correlate to location status or location type
        marker.category = 1;

        // console.log("---------- marker ----------");
        // console.log(marker);
        // console.log("---------- marker ----------");

        pruneCluster.RegisterMarker(marker);
    })
    
    this.map.addLayer(pruneCluster);

</script>
@endsection
