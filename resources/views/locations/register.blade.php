@extends('layouts.app')

@section('content')

<script src="{{ asset('js/leaflet.js') }}"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Register Location</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('location.store') }}">
                    	@csrf
                    	@method('POST')

                        <div id="map" style="width: 100%; height: 400px;"></div>
                        <hr />
                        <div class="form-group">
                            <p>
                                <label>
                                    Name:
                                    <input
                                        id="locationName"
                                        name="locationName"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter location name."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Address:
                                    <input
                                        id="locationAddress"
                                        name="locationAddress"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter location address."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Description:
                                    <input
                                        id="locationDescription"
                                        name="locationDescription"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter location description."
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Status:
                                    <input
                                        id="locationStatus"
                                        name="locationStatus"
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter location status."
                                        required
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Rating:
                                    <input
                                        id="locationRating"
                                        name="locationRating"
                                        type="number"
                                        class="form-control"
                                        placeholder="Enter location rating."
                                        required
                                        step="0.01"
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Latitude:
                                    <input
                                        id="locationLatitude"
                                        name="locationLatitude"
                                        type="text"
                                        class="form-control"
                                        placeholder="Click on map to set latitude."
                                        step="0.0"
                                        required
                                        readOnly
                                    />
                                </label>
                            </p>
                            <p>
                                <label>
                                    Longitude:
                                    <input
                                        id="locationLongitude"
                                        name="locationLongitude"
                                        type="text"
                                        class="form-control"
                                        placeholder="Click on map to set longitude."
                                        step="0.0"
                                        required
                                        readOnly
                                    />
                                </label>
                            </p>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Create Location
                        </button>
                    </form>
                    <hr />
                    @foreach ($locations as $location)
	                    <div id="{{ $location->_id }}" class="media">
			                <div class="media-body">
			                    <form method="POST" action="{{ route('location.destroy', $location->_id) }}">
			                    	@csrf
									@method('DELETE')

									<p>{{ $location->locationName }}</p>
									<a href="{{ route('location.show', $location->_id) }}">
					                    <button class="btn btn-sm btn-success">
			                        		View
					                    </button>
				                    </a>
				                    <a href="{{ route('location.edit', $location->_id) }}">
				                    	<button class="btn btn-sm btn-success">
				                        	Edit
				                    	</button>
				                	</a>
				                    <button type="submit" class="btn btn-sm btn-danger float-right">
				                        DELETE
				                    </button>
			                	</form>
			                </div>
			            </div>
		            @endforeach
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

	function updateLatLng(state, e){
        document.getElementById('locationLatitude').value = e.latlng.lat;
        document.getElementById('locationLongitude').value = e.latlng.lng;
    }

    map.on("click", updateLatLng.bind(null, this));


</script>
@endsection
