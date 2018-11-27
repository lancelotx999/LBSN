
@if (Auth::check())

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3 col-md-2 my-auto text-center">
                            <img src="{{ $users->profileImage }}" alt="Profile image" 
                            class="img-fluid rounded" style="max-height: 128px" />      
                        </div>
                        <div class="col-sm-9 col-md-10">
                            <h4>
                                {{ $users->name }} 
                                <small class="text-muted">
                                    {{ $users->role }}
                                </small>
                            </h4>
                            <h6>Name</h6>
                            <hr/>
                            <h4>{{ $users->email }}</h4>
                            <h6>Email</h6>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@endif