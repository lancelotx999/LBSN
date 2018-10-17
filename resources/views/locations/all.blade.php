@extends('layouts.app')

@section('content')

<script src="{{ asset('js/leaflet.js') }}"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register Location</div>
                <div class="card-body">
                    <div id="map" style={mapStyle} />
                    <hr />
                    <!-- {this.renderLocations()} -->
                </div>
            </div>
            <div></div>
        </div>

    </div>
</div>

<script type="text/javascript">
	L.map('map', {
        center: [1.5510714615890955, 110.34356832504274],
        zoom: 16,
        layers: [
            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }),
        ]
    })
</script>
@endsection
