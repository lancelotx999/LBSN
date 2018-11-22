@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('business.index') }}">Businesses</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('business.show', $business->_id) }}">View {{ $business->name }}</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">View Business</div>
                <div class="card-body">
                    @foreach ($business->images as $image)
                        {{$image->name}}
                        {{$image->description}}
                        <img src = '{{ $image->data }}' />';
                    @endforeach
                    <p>
                        Name: {{ $business->name }}
                    </p>
                    <p>
                        Description: {{ $business->description }}
                    </p>
                    <p>
                        Services:
                        <ul>
                        @foreach ($business->services as $service)
                            <li>{{ $service }}</li>
                        @endforeach
                        </ul>
                    </p>
                    <p>
                        Contact Number: {{ $business->contact_number }}
                    </p>
                    <hr />
                    <p><a href="{{ url()->previous() }}">Return to previous page</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@php

if (empty($business)) { $business = null; }

@endphp

@endsection
