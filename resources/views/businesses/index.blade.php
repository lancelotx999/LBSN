@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('business.index') }}">Businesses</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">All Businesses</div>
                <div class="card-body">
                    @if ($businesses->isEmpty())
                        <br />
                        <h1 class="display-4">Hello, it seems empty here!</h1>
                        <p class="lead">Why don't you try to add some stuff?</p>
                        <hr />
                    @endif
                    @foreach ($businesses as $business)
	                    <div id="{{ $business->_id }}" class="media">
			                <div class="media-body">
			                    <h5>{{ $business->name }}</h5>
                                <div class="col-sm-6">
                                    <select id="ratingModule{{ $business->id }}" style="float: right;">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <a href="{{ route('business.show', $business->_id) }}">
                                            <button class="btn btn-sm btn-success">
                                                View
                                            </button>
                                        </a>
                                        <a href="{{ route('business.edit', $business->_id) }}">
                                            <button class="btn btn-sm btn-success">
                                                Edit
                                            </button>
                                        </a>
                                    </div>

                                    <div class="col-sm-8">
                                        <form method="POST" action="{{ route('business.destroy', $business->_id) }}">
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
                    <a href="{{ route('business.create') }}">Create businesses</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var businesses = {!! json_encode($businesses->toArray()) !!};

    console.log("---------- businesses ----------");
    console.log(businesses);
    console.log("---------- businesses ----------");

    businesses.forEach(function(d){
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


</script>
@endsection
