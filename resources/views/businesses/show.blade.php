@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                @if (url()->previous() == route('business.index'))
                    <a href="{{ route('business.index') }}">My Businesses</a>
                @else
                    <a href="{{ url('/business/listing') }}">Businesses</a>
                @endif
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
                            @foreach ($business->images as $image)
                            <img src="{{ $image->data }}" class="img-fluid rounded" 
                            alt="{{ $image->name }}" style="max-height: 128px" />
                            @endforeach
                        </li>
                    </ul>
                    <br />
                    <div class="accordion" id="accordionExample">
                        @if (!($business->owner_id == Auth::id()))
                        <a class="nounderline" 
                        href="/contract/create/{{ $business->_id }}">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-file-signature fa-fw"></i>
                                Create a new contract
                            </button>
                        </a>
                        <span class="d-none d-sm-block d-md-none"><br /></span>
                        @endif
                        <a class="nounderline" 
                        href="{{ url()->previous() }}">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-arrow-circle-left fa-fw"></i> 
                                Previous page
                            </button>
                        </a>
                        <button class="btn btn-link" type="button" 
                        data-toggle="collapse" data-target="#collapseOne" 
                        aria-expanded="true" aria-controls="collapseOne">
                            <i class="fas fa-chevron-circle-down fa-fw"></i> 
                            Click here to write a review
                        </button>
                        <div 
                            id="collapseOne" class="collapse" 
                            aria-labelledby="headingOne" data-parent="#accordionExample">
                            <form method="POST" action="{{ route('review.store') }}">
                                @csrf
                                @method('POST')

                                <div class="form-group"><br />
                                    <textarea class="form-control" id="content" name="content" rows="5" placeholder="Please leave a review."></textarea>
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
                                    value="{{ $business->_id }}"
                                    required
                                />
                                <button type="submit" class="btn btn-primary">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    </div>
                    <hr />
                    @if ($business->reviews->isEmpty())
                    @else
                    <h4><i class="far fa-comments fa-fw"></i> Reviews</h4>
                    <hr />
                    @foreach ($business->reviews as $review)
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

if (empty($business)) { $business = null; }

@endphp

<script type="text/javascript">
    var read = "{{ $business }}";
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
</script>

@endsection
