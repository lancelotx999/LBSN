@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                @if (url()->previous() == route('property.index'))
                    <a href="{{ route('property.index') }}">Properties</a>
                @else
                    <a href="{{ url('/property/listing') }}">Properties</a>
                @endif
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('property.show', $property->_id) }}">View {{ $property->name }}</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">View Property</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="map" style="width: 100%;"></div>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Name:</strong><br />
                                    {{ $property->name }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Address:</strong><br />
                                    {{ $property->address }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Description:</strong><br />
                                    {{ $property->description }}
                                </li>
                                <li class="list-group-item text-capitalize">
                                    <strong>Status:</strong><br />
                                    {{ $property->status }}
                                </li>
                                <li class="list-group-item">
                                    <ul class="list-unstyled list-inline">
                                        <li>
                                        <strong>Tags:</strong>
                                        </li>
                                        @foreach ($property->tags as $tag)
                                            <li class="list-inline-item">
                                                <span class="border border-info bg-info text-light rounded">
                                                    &nbsp;{{ $tag }}&nbsp;
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="list-group-item">
                                    <strong>Rating:</strong>
                                    <select id="ratingModule" class="custom-select">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </li>
                                <li class="list-group-item">
                                    @foreach ($property->images as $image)
                                    <img src="{{ $image->data }}" class="img-fluid rounded" 
                                    alt="{{ $image->name }}" style="max-height: 128px" />
                                    @endforeach
                                </li>
                            </ul>
                            <br />
                            @if (!($property->owner_id == Auth::id()))
                            <a class="nounderline" 
                            href="/contract/create/{{ $property->_id }}">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-file-signature fa-fw"></i>
                                    Create a contract
                                </button>
                            </a>
                            @endif
                            <a class="nounderline" 
                            href="{{ url()->previous() }}">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-arrow-circle-left fa-fw"></i> 
                                    Previous page
                                </button>
                            </a>
                        </div>
                    </div>
                    <br />
                    <div class="accordion" id="accordionExample">
                        <button class="btn btn-link" type="button" 
                        data-toggle="collapse" data-target="#collapseOne" 
                        aria-expanded="true" aria-controls="collapseOne">
                            <i class="fas fa-chevron-circle-down fa-fw"></i> 
                            Click here to write a review
                        </button>
                        <button class="btn btn-link" type="button"
                        onclick="zoomMarker({{ $property->latitude }}, {{ $property->longitude }})">
                            <i class="fas fa-map-marker-alt fa-fw"></i> 
                            Click here to show on map
                        </button>
                        <div 
                            id="collapseOne" class="collapse" 
                            aria-labelledby="headingOne" data-parent="#accordionExample">
                            <form method="POST" action="{{ route('review.store') }}">
                                @csrf
                                @method('POST')

                                <div class="form-group">
                                    <br /><textarea class="form-control" id="content" name="content" rows="5" placeholder="Please leave a review."></textarea>
                                </div>

                                <input
                                    id="reviewer_id" name="reviewer_id" type="hidden"
                                    class="form-control"
                                    value="{{ Auth::id() }}"
                                    required
                                />
                                <input
                                    id="reviewee_id" name="reviewee_id" type="hidden"
                                    class="form-control"
                                    value="{{ $property->_id }}"
                                    required
                                />
                                <button type="submit" class="btn btn-primary">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    </div>
                    <hr />
                    @if ($property->reviews->isEmpty())
                    @else
                    <h4><i class="far fa-comments fa-fw"></i> Reviews</h4>
                    <hr />
                    @foreach ($property->reviews as $review)
                        <div class="row">
                            <div class="col-sm-3 col-md-2 my-auto text-center">
                                <img src="{{ $review->user->profileImage }}" alt="Profile image" 
                                class="img-fluid rounded" style="max-height: 128px" />
                            </div>
                            <div class="col-sm-9 col-md-10">
                                <div class="row">
                                    <h5><a href="/users/{{ $review->reviewer_id }}">
                                        {{ $review->user->name }}
                                    </a></h5>
                                </div>
                                <div class="row">
                                    <p>{{ $review->content }}</p>
                                </div>
                            </div>
                        </div>
                        <hr />
		            @endforeach
                    @endif
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

    // Latitude, Longitude, Zoom
    function zoomMarker(lat, long) {
        map.setView([lat, long], 17)
    }

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

        var popupContent = "Property Name: " + d.name + "</br>" +
                            "Property Address: " + d.address + "</br>" +
                            "Property Description: " + d.description + "</br>" +
                            "Property Rating: " + d.rate + "</br>" +
                            "Property Status: " + d.status + "</br>";

        var marker = new PruneCluster.Marker(d.latitude, d.longitude,{
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
