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
@endsection
