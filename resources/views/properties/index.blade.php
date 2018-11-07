@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Properties</div>
                <div class="card-body">
                    <div id="map" style="width: 100%; height: 400px;"></div>
                    <hr />
                    @foreach ($properties as $property)
	                    <!-- <div id="{{ $property->_id }}" class="media">
			                <div class="media-body">
			                    <h5>{{ $property->name }}</h5>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <a href="{{ route('property.show', $property->_id) }}">
                                            <button class="btn btn-sm btn-success">
                                                View
                                            </button>
                                        </a>
                                        <a href="{{ route('property.edit', $property->_id) }}">
                                            <button class="btn btn-sm btn-success">
                                                Edit
                                            </button>
                                        </a>
                                    </div>

                                    <div class="col-sm-8">
                                        <form method="POST" action="{{ route('property.destroy', $property->_id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger float-right">
                                                DELETE
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <hr />
			                </div>
			            </div> -->
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="https://vignette.wikia.nocookie.net/project-pokemon/images/4/47/Placeholder.png/revision/latest?cb=20170330235552" style="width: 100%">
                                </img>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <h5>{{ $property->name }}</h5>
                                </div>
                                <div class="row">
                                    <p>{{ $property->address }}</p>
                                </div>
                                <div class="row">
                                    <p>{{ $property->description }}</p>
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="{{ route('property.show', $property->_id) }}">
                                    <button class="btn btn-sm btn-success">
                                        View
                                    </button>
                                </a>
                                <a href="{{ route('property.edit', $property->_id) }}">
                                    <button class="btn btn-sm btn-success">
                                        Edit
                                    </button>
                                </a>
                            </div>

                            <div class="col-sm-8">
                                <form method="POST" action="{{ route('property.destroy', $property->_id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger float-right">
                                        DELETE
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr />

		            @endforeach
                    <a href="{{ route('property.create') }}">Create properties</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var map = L.map('map', {
        center: [1.5510714615890955, 110.34356832504274],
        zoom: 16,
        layers: [
            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }),
        ]
    })

    var locations = {!! json_encode($properties->toArray()) !!};

    console.log("---------- locations ----------");
    console.log(locations);
    console.log("---------- locations ----------");

    // var pruneCluster = new PruneClusterForLeaflet();
    //
    // PruneCluster.Cluster.ENABLE_MARKERS_LIST = true;
    //
    // pruneCluster.PrepareLeafletMarker = function(leafletMarker, data) {
    //     // leafletMarker.setIcon(/*... */); // See http://leafletjs.com/reference.html#icon
    //
    //     // console.log("---------- data PrepareLeafletMarker ----------");
    //     // console.log(data);
    //     // console.log("---------- data PrepareLeafletMarker ----------");
    //     // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
    //     // console.log(leafletMarker);
    //     // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
    //     // console.log("---------- this PrepareLeafletMarker ----------");
    //     // console.log(this);
    //     // console.log("---------- this PrepareLeafletMarker ----------");
    //
    //     //listeners can be applied to markers in this function
    //     leafletMarker.on('click', function(){
    //         console.log("---------- data PrepareLeafletMarker ----------");
    //         console.log(data);
    //         console.log("---------- data PrepareLeafletMarker ----------");
    //     });
    //
    //     // A popup can already be attached to the marker
    //     // bindPopup can override it, but it's faster to update the content instead
    //     if (leafletMarker.getPopup()) {
    //         leafletMarker.setPopupContent(data.popup);
    //     }
    //     else {
    //         leafletMarker.bindPopup(data.popup);
    //     }
    //
    //     // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
    //     // console.log(leafletMarker);
    //     // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
    // };
    //
    // pruneCluster.BuildLeafletCluster = function(cluster, position) {
    //     var m = new L.Marker(position, {
    //         icon: pruneCluster.BuildLeafletClusterIcon(cluster)
    //     });
    //
    //     m.on('click', function() {
    //         // Compute the  cluster bounds (it's slow : O(n))
    //         var markersArea = pruneCluster.Cluster.FindMarkersInArea(cluster.bounds);
    //         var b = pruneCluster.Cluster.ComputeBounds(markersArea);
    //
    //         if (b) {
    //             var bounds = new L.LatLngBounds(new L.LatLng(b.minLat, b.maxLng),new L.LatLng(b.maxLat, b.minLng));
    //
    //             var zoomLevelBefore = pruneCluster._map.getZoom();
    //             var zoomLevelAfter = pruneCluster._map.getBoundsZoom(bounds, false, new L.Point(20, 20, null));
    //
    //             // If the zoom level doesn't change
    //             if (zoomLevelAfter === zoomLevelBefore) {
    //                 // Send an event for the LeafletSpiderfier
    //                 pruneCluster._map.fire('overlappingmarkers', {
    //                     cluster: pruneCluster,
    //                     markers: markersArea,
    //                     center: m.getLatLng(),
    //                     marker: m
    //                 });
    //
    //                 pruneCluster._map.setView(position, zoomLevelAfter);
    //             }
    //             else {
    //                 pruneCluster._map.fitBounds(bounds);
    //             }
    //         }
    //     });
    //     m.on('mouseover', function() {
    //         //do mouseover stuff here
    //     });
    //     m.on('mouseout', function() {
    //         //do mouseout stuff here
    //     });
    //
    //     return m;
    // };
    //
    // pruneCluster.BuildLeafletClusterIcon = function(cluster) {
    //
    //     var e = new L.Icon.MarkerCluster();
    //
    //     e.stats = cluster.stats; // if you have categories on your markers
    //     e.population = cluster.population; // the number of markers inside the cluster
    //
    //     var markers = cluster.GetClusterMarkers()
    //
    //     // console.log("---------- markers ----------");
    //     // console.log(markers);
    //     // console.log("---------- markers ----------");
    //
    //     return e;
    // };
    //
    // var colors = ['#ff4b00', '#bac900', '#EC1813', '#55BCBE', '#D2204C', '#FF0000', '#ada59a', '#3e647e'],
    //     pi2 = Math.PI * 2;
    //
    // L.Icon.MarkerCluster = L.Icon.extend({
    //     options: {
    //         iconSize: new L.Point(44, 44),
    //         className: 'prunecluster leaflet-markercluster-icon'
    //     },
    //
    //     createIcon: function () {
    //         // based on L.Icon.Canvas from shramov/leaflet-plugins (BSD licence)
    //         var e = document.createElement('canvas');
    //         this._setIconStyles(e, 'icon');
    //         var s = this.options.iconSize;
    //         e.width = s.x;
    //         e.height = s.y;
    //         this.draw(e.getContext('2d'), s.x, s.y);
    //         return e;
    //     },
    //
    //     createShadow: function () {
    //         return null;
    //     },
    //
    //     draw: function(canvas, width, height) {
    //         var lol = 0;
    //         var start = 0;
    //         for (var i = 0, l = colors.length; i < l; ++i) {
    //
    //             var size = this.stats[i] / this.population;
    //
    //             if (size > 0) {
    //                 canvas.beginPath();
    //                 canvas.moveTo(22, 22);
    //                 canvas.fillStyle = colors[i];
    //                 var from = start + 0.14,
    //                 to = start + size * pi2;
    //
    //                 if (to < from) {
    //                     from = start;
    //                 }
    //                 canvas.arc(22,22,22, from, to);
    //
    //                 start = start + size*pi2;
    //                 canvas.lineTo(22,22);
    //                 canvas.fill();
    //                 canvas.closePath();
    //             }
    //
    //         }
    //
    //         canvas.beginPath();
    //         canvas.fillStyle = 'white';
    //         canvas.arc(22, 22, 18, 0, Math.PI*2);
    //         canvas.fill();
    //         canvas.closePath();
    //
    //         canvas.fillStyle = '#555';
    //         canvas.textAlign = 'center';
    //         canvas.textBaseline = 'middle';
    //         canvas.font = 'bold 12px sans-serif';
    //
    //         canvas.fillText(this.population, 22, 22, 40);
    //     }
    // });
    //
    // locations.forEach(function (d){
    //     console.log("---------- d ----------");
    //     console.log(d);
    //     console.log("---------- d ----------");
    //
    //     var popupContent = "Property Name: " + d.locationName + "</br>" +
    //                         "Property Address: " + d.locationAddress + "</br>" +
    //                         "Property Description: " + d.locationDescription + "</br>" +
    //                         "Property Rating: " + d.locationRating + "</br>" +
    //                         "Property Status: " + d.locationStatus + "</br>" +
    //                         "Property Owner Name: " + d.user.name + "</br>" +
    //                         "Property Owner Email: " + d.user.email + "</br>";
    //
    //     var marker = new PruneCluster.Marker(d.locationLatitude, d.locationLongitude,{
    //         popup: popupContent
    //     });
    //
    //
    //     //TODO: this should correlate to location status or location type
    //     marker.category = 1;
    //
    //     // console.log("---------- marker ----------");
    //     // console.log(marker);
    //     // console.log("---------- marker ----------");
    //
    //     pruneCluster.RegisterMarker(marker);
    // })
    //
    // this.map.addLayer(pruneCluster);

    locations.forEach(function(d){
        console.log("---------- d ----------");
        console.log(d);
        console.log("---------- d ----------");

        var popupContent = "Property Name: " + d.locationName + "</br>" +
                                "Property Address: " + d.locationAddress + "</br>" +
                                "Property Description: " + d.locationDescription + "</br>" +
                                "Property Rating: " + d.locationRating + "</br>" +
                                "Property Status: " + d.locationStatus + "</br>" +
                                "Property Owner Name: " + d.user.name + "</br>" +
                                "Property Owner Email: " + d.user.email + "</br>";

        L.marker([d.locationLatitude, d.locationLongitude]).addTo(map)
            .bindPopup(popupContent);
    })
</script>
@endsection
