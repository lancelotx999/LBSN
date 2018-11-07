@extends('layouts.app')

@section('content')




<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register Location</div>
                <div class="card-body">
                    <div id="map" style="width: 100%; height: 400px;"></div>
                    <hr />
                    <p>
                        Name: {{ $property->name }}
                    </p>
                    <p>
                        Address: {{ $property->address }}
                    </p>
                    <p>
                        Description: {{ $property->description }}
                    </p>
                    <p>
                        Status: {{ $property->status }}
                    </p>
                    <p>
                        Rating:
                        <select id="ratingModule">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </p>
                    <p>
                        Latitude: {{ $property->latitude }}
                    </p>
                    <p>
                        Longitude: {{ $property->longitude }}
                    </p>
                    <p>
                        <a href="{{ route('property.show', ['id' => $property->id]) }}">
                            Create Property Contract
            	        </a>
                    <p />
                    <p>
                        <a href="{{ route('property.show', ['id' => $property->id]) }}">
                            Create Service Contract
                        </a>
                    <p />
                    <hr />
                    <form method="POST" action="{{ route('review.store') }}">
                        @csrf
                        @method('POST')

                        <textarea id="content" name="content" rows="5" cols="50" placeholder="Please leave a review."></textarea>
                        <input
                            id="reviewer_id"
                            name="reviewer_id"
                            type="hidden"
                            class="form-control"
                            value="{{ Auth::id() }}"
                            placeholder="Enter reviewer_id ID."
                            required
                        />
                        <input
                            id="reviewee_id"
                            name="reviewee_id"
                            type="hidden"
                            class="form-control"
                            value="{{ $property->_id }}"
                            placeholder="Enter reviewee_id ID."
                            required
                        />
                        <button type="submit" class="btn btn-primary">
                            Review
                        </button>
                    </form>

                    <hr />
                    Reviews
                    <hr />
                    @foreach ($property->reviews as $review)
                        <p>{{ $review->content }}</p>
                        <hr />
		            @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

@php

if (empty($property)) { $property = null; }

@endphp

<script type="text/javascript">

    var read = "{{ $property }}";
    var json = read.replace(/&quot;/g, '"');
    var data = JSON.parse(json);

    console.log("---------- data ----------");
    console.log(data);
    console.log("---------- data ----------");

    $(function() {
        $('#ratingModule').barrating({
            theme: 'css-stars',
            initialRating: data.rate,
            onSelect: function(value, text, event) {
                if (typeof(event) !== 'undefined') {
                    // rating was selected by a user
                    // console.log("---------- data ----------");
                    // console.log(data);
                    // console.log("---------- data ----------");

                    data.rater_id = '{{ Auth::user()->id }}';
                    data.ratee_id = data._id;
                    data.rate = $(event.target).data("rating-value");

                    // console.log("---------- data ----------");
                    // console.log(data);
                    // console.log("---------- data ----------");
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: '/rating/store',
                        data: data,
                        success: function() {
                            // console.log(this);
                            // console.log("Valueadded");
                        }
                    })
                }
            }
        });
    });

    var map = L.map('map', {
        center: [1.5510714615890955, 110.34356832504274],
        zoom: 16,
        layers: [
            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }),
        ]
    })

    // var location = {!! json_encode($property->toArray()) !!};
    //
    // console.log("---------- read ----------");
    // console.log(read);
    // console.log("---------- read ----------");
    // console.log("---------- json ----------");
    // console.log(json);
    // console.log("---------- json ----------");
    // console.log("---------- data ----------");
    // console.log(data);
    // console.log("---------- data ----------");
    // console.log("---------- locations ----------");
    // console.log(location);
    // console.log("---------- locations ----------");



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

    [data].forEach(function (d){
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

</script>
@endsection
