@extends('layouts.app')

@section('content')

<script src="{{ asset('js/leaflet.js') }}"></script>
<script src="{{ asset('js/PruneCluster.js') }}"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">View Property Contracts</div>
                <div class="card-body">
                    <div id="map" style="width: 100%; height: 400px;"></div>
                    <hr />
                    @foreach ($propertyContracts as $propertyContract)
	                    <div id="{{ $propertyContract->_id }}" class="media">
			                <div class="media-body">
			                    <h5>{{ $propertyContract->location->locationName }}</h5>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <a href="{{ route('propertyContract.show', $propertyContract->_id) }}">
                                            <button class="btn btn-sm btn-success">
                                                View
                                            </button>
                                        </a>
                                        <a href="{{ route('propertyContract.edit', $propertyContract->_id) }}">
                                            <button class="btn btn-sm btn-success">
                                                Edit
                                            </button>
                                        </a>
                                    </div>

                                    <div class="col-sm-8">
                                        <form method="POST" action="{{ route('propertyContract.destroy', $propertyContract->_id) }}">
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
			            </div>
		            @endforeach
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    var read = "{{ $users }}";
    var json = read.replace(/&quot;/g, '"');
    var userData = JSON.parse(json);

    var read = "{{ $locations }}";
    var json = read.replace(/&quot;/g, '"');
    var locationData = JSON.parse(json);

    var read = "{{ $propertyContracts }}";
    var json = read.replace(/&quot;/g, '"');
    var propertyContractData = JSON.parse(json);

    // console.log("---------- json ----------");
    // console.log(json);
    // console.log("---------- json ----------");
    // console.log("---------- json2 ----------");
    // console.log(json2);
    // console.log("---------- json2 ----------");

    console.log("---------- userData ----------");
    console.log(userData);
    console.log("---------- userData ----------");
    console.log("---------- locationData ----------");
    console.log(locationData);
    console.log("---------- locationData ----------");
    console.log("---------- propertyContractData ----------");
    console.log(propertyContractData);
    console.log("---------- propertyContractData ----------");

    // var map = L.map('map', {
    //     center: [1.5510714615890955, 110.34356832504274],
    //     zoom: 16,
    //     layers: [
    //         L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    //             attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    //         }),
    //     ]
    // })
    //
    // var propertyContracts = {!! json_encode($propertyContracts->toArray()) !!};
    //
    // console.log("---------- propertyContracts ----------");
    // console.log(propertyContracts);
    // console.log("---------- propertyContracts ----------");
    //
    // // var pruneCluster = new PruneClusterForLeaflet();
    // //
    // // PruneCluster.Cluster.ENABLE_MARKERS_LIST = true;
    // //
    // // pruneCluster.PrepareLeafletMarker = function(leafletMarker, data) {
    // //     // leafletMarker.setIcon(/*... */); // See http://leafletjs.com/reference.html#icon
    // //
    // //     // console.log("---------- data PrepareLeafletMarker ----------");
    // //     // console.log(data);
    // //     // console.log("---------- data PrepareLeafletMarker ----------");
    // //     // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
    // //     // console.log(leafletMarker);
    // //     // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
    // //     // console.log("---------- this PrepareLeafletMarker ----------");
    // //     // console.log(this);
    // //     // console.log("---------- this PrepareLeafletMarker ----------");
    // //
    // //     //listeners can be applied to markers in this function
    // //     leafletMarker.on('click', function(){
    // //         console.log("---------- data PrepareLeafletMarker ----------");
    // //         console.log(data);
    // //         console.log("---------- data PrepareLeafletMarker ----------");
    // //     });
    // //
    // //     // A popup can already be attached to the marker
    // //     // bindPopup can override it, but it's faster to update the content instead
    // //     if (leafletMarker.getPopup()) {
    // //         leafletMarker.setPopupContent(data.popup);
    // //     }
    // //     else {
    // //         leafletMarker.bindPopup(data.popup);
    // //     }
    // //
    // //     // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
    // //     // console.log(leafletMarker);
    // //     // console.log("---------- leafletMarker PrepareLeafletMarker POST ----------");
    // // };
    // //
    // // pruneCluster.BuildLeafletCluster = function(cluster, position) {
    // //     var m = new L.Marker(position, {
    // //         icon: pruneCluster.BuildLeafletClusterIcon(cluster)
    // //     });
    // //
    // //     m.on('click', function() {
    // //         // Compute the  cluster bounds (it's slow : O(n))
    // //         var markersArea = pruneCluster.Cluster.FindMarkersInArea(cluster.bounds);
    // //         var b = pruneCluster.Cluster.ComputeBounds(markersArea);
    // //
    // //         if (b) {
    // //             var bounds = new L.LatLngBounds(new L.LatLng(b.minLat, b.maxLng),new L.LatLng(b.maxLat, b.minLng));
    // //
    // //             var zoomLevelBefore = pruneCluster._map.getZoom();
    // //             var zoomLevelAfter = pruneCluster._map.getBoundsZoom(bounds, false, new L.Point(20, 20, null));
    // //
    // //             // If the zoom level doesn't change
    // //             if (zoomLevelAfter === zoomLevelBefore) {
    // //                 // Send an event for the LeafletSpiderfier
    // //                 pruneCluster._map.fire('overlappingmarkers', {
    // //                     cluster: pruneCluster,
    // //                     markers: markersArea,
    // //                     center: m.getLatLng(),
    // //                     marker: m
    // //                 });
    // //
    // //                 pruneCluster._map.setView(position, zoomLevelAfter);
    // //             }
    // //             else {
    // //                 pruneCluster._map.fitBounds(bounds);
    // //             }
    // //         }
    // //     });
    // //     m.on('mouseover', function() {
    // //         //do mouseover stuff here
    // //     });
    // //     m.on('mouseout', function() {
    // //         //do mouseout stuff here
    // //     });
    // //
    // //     return m;
    // // };
    // //
    // // pruneCluster.BuildLeafletClusterIcon = function(cluster) {
    // //
    // //     var e = new L.Icon.MarkerCluster();
    // //
    // //     e.stats = cluster.stats; // if you have categories on your markers
    // //     e.population = cluster.population; // the number of markers inside the cluster
    // //
    // //     var markers = cluster.GetClusterMarkers()
    // //
    // //     // console.log("---------- markers ----------");
    // //     // console.log(markers);
    // //     // console.log("---------- markers ----------");
    // //
    // //     return e;
    // // };
    // //
    // // var colors = ['#ff4b00', '#bac900', '#EC1813', '#55BCBE', '#D2204C', '#FF0000', '#ada59a', '#3e647e'],
    // //     pi2 = Math.PI * 2;
    // //
    // // L.Icon.MarkerCluster = L.Icon.extend({
    // //     options: {
    // //         iconSize: new L.Point(44, 44),
    // //         className: 'prunecluster leaflet-markercluster-icon'
    // //     },
    // //
    // //     createIcon: function () {
    // //         // based on L.Icon.Canvas from shramov/leaflet-plugins (BSD licence)
    // //         var e = document.createElement('canvas');
    // //         this._setIconStyles(e, 'icon');
    // //         var s = this.options.iconSize;
    // //         e.width = s.x;
    // //         e.height = s.y;
    // //         this.draw(e.getContext('2d'), s.x, s.y);
    // //         return e;
    // //     },
    // //
    // //     createShadow: function () {
    // //         return null;
    // //     },
    // //
    // //     draw: function(canvas, width, height) {
    // //         var lol = 0;
    // //         var start = 0;
    // //         for (var i = 0, l = colors.length; i < l; ++i) {
    // //
    // //             var size = this.stats[i] / this.population;
    // //
    // //             if (size > 0) {
    // //                 canvas.beginPath();
    // //                 canvas.moveTo(22, 22);
    // //                 canvas.fillStyle = colors[i];
    // //                 var from = start + 0.14,
    // //                 to = start + size * pi2;
    // //
    // //                 if (to < from) {
    // //                     from = start;
    // //                 }
    // //                 canvas.arc(22,22,22, from, to);
    // //
    // //                 start = start + size*pi2;
    // //                 canvas.lineTo(22,22);
    // //                 canvas.fill();
    // //                 canvas.closePath();
    // //             }
    // //
    // //         }
    // //
    // //         canvas.beginPath();
    // //         canvas.fillStyle = 'white';
    // //         canvas.arc(22, 22, 18, 0, Math.PI*2);
    // //         canvas.fill();
    // //         canvas.closePath();
    // //
    // //         canvas.fillStyle = '#555';
    // //         canvas.textAlign = 'center';
    // //         canvas.textBaseline = 'middle';
    // //         canvas.font = 'bold 12px sans-serif';
    // //
    // //         canvas.fillText(this.population, 22, 22, 40);
    // //     }
    // // });
    // //
    // // propertyContracts.forEach(function (d){
    // //     console.log("---------- d ----------");
    // //     console.log(d);
    // //     console.log("---------- d ----------");
    // //
    // //     var popupContent = "Property Name: " + d.propertyContractName + "</br>" +
    // //                         "Property Address: " + d.propertyContractAddress + "</br>" +
    // //                         "Property Description: " + d.propertyContractDescription + "</br>" +
    // //                         "Property Rating: " + d.propertyContractRating + "</br>" +
    // //                         "Property Status: " + d.propertyContractStatus + "</br>" +
    // //                         "Property Owner Name: " + d.user.name + "</br>" +
    // //                         "Property Owner Email: " + d.user.email + "</br>";
    // //
    // //     var marker = new PruneCluster.Marker(d.propertyContractLatitude, d.propertyContractLongitude,{
    // //         popup: popupContent
    // //     });
    // //
    // //
    // //     //TODO: this should correlate to propertyContract status or propertyContract type
    // //     marker.category = 1;
    // //
    // //     // console.log("---------- marker ----------");
    // //     // console.log(marker);
    // //     // console.log("---------- marker ----------");
    // //
    // //     pruneCluster.RegisterMarker(marker);
    // // })
    // //
    // // this.map.addLayer(pruneCluster);
    //
    // propertyContracts.forEach(function(d){
    //     console.log("---------- d ----------");
    //     console.log(d);
    //     console.log("---------- d ----------");
    //
    //     var popupContent = "Property Name: " + d.propertyContractName + "</br>" +
    //                             "Property Address: " + d.propertyContractAddress + "</br>" +
    //                             "Property Description: " + d.propertyContractDescription + "</br>" +
    //                             "Property Rating: " + d.propertyContractRating + "</br>" +
    //                             "Property Status: " + d.propertyContractStatus + "</br>" +
    //                             "Property Owner Name: " + d.user.name + "</br>" +
    //                             "Property Owner Email: " + d.user.email + "</br>";
    //
    //     L.marker([d.propertyContractLatitude, d.propertyContractLongitude]).addTo(map)
    //         .bindPopup(popupContent);
    // })


</script>
@endsection
