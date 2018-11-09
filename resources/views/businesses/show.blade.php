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
                    <p>
                        Name: {{ $business->name }}
                    </p>
                    <p>
                        Description: {{ $business->description }}
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
                            value="{{ $business->_id }}"
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
                    @foreach ($business->reviews as $review)
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="https://vignette.wikia.nocookie.net/project-pokemon/images/4/47/Placeholder.png/revision/latest?cb=20170330235552" style="width: 100%">
                                </img>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <h5><a href="/user/{{ $review->reviewer_id }}">{{ $review->user->name }}</a></h5>
                                </div>
                                <div class="row">
                                    <p>{{ $review->content }}</p>
                                </div>
                            </div>
                        </div>
                        <hr />
		            @endforeach
                    <p><a href="{{ url()->previous() }}">Return to previous page</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

@php

if (empty($business)) { $business = null; }

@endphp

@endsection
