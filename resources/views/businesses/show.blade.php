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
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Name:</strong><br />
                            {{ $business->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Description:</strong><br />
                            {{ $business->description }}
                        </li>
                        <li class="list-group-item">
                            <ul class="list-unstyled list-inline">
                                <li>
                                <strong>Services:</strong>
                                </li>
                                @foreach ($business->services as $service)
                                    <li class="list-inline-item">
                                        <span class="border border-warning bg-warning text-dark rounded">
                                            &nbsp;{{ $service }}&nbsp;
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="list-group-item">
                            <strong>Contact Number:</strong><br />
                            {{ $business->contact_number }}
                        </li>
                    </ul>
                    <br />
                    <a href="/contract/create/{{ $business->_id }}">
                        <button class="btn btn-link" type="button">
                            <i class="fas fa-file-signature fa-fw"></i>
                            Create contract page
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@php

if (empty($business)) { $business = null; }

@endphp

@endsection
