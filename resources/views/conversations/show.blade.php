@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('conversation.index') }}">Messages</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('conversation.show', $conversation->_id) }}">View: {{ $conversation->title }}</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">View Message</div>
                <div class="card-body">
                    <p>
                        Title: {{ $conversation->title }}
                    </p>
                    <hr />
                    @foreach (array_reverse($conversation->messages) as $message)
                        <div class="row">
                            <div class="col-sm-3 col-md-2 my-auto text-center">
                                <img src="{{ $message->sender->profileImage }}" alt="Profile image"
                                class="img-fluid rounded" style="max-height: 128px" />
                            </div>
                            <div class="col-sm-9 col-md-10">
                                <div class="row">
                                    <h5><a href="/users/{{ $message->sender->_id }}">{{ $message->sender->name }}</a></h5>
                                </div>
                                <div class="row">
                                    <p>{{ $message->content }}</p>
                                </div>
                            </div>
                        </div>
                        <hr />
		            @endforeach
                    <form method="POST" action="{{ route('conversation.update', $conversation) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                        <textarea id="message" name="content" rows="5"
                        placeholder="Please leave a reply." class="form-control"></textarea>
                        </div>

                        @if(Auth::user()->id == $conversation->sender->_id)

                            <input
                                id="sender_id"
                                name="sender_id"
                                type="hidden"
                                class="form-control"
                                value="{{ Auth::user()->id }}"
                                placeholder="Enter sender_id ID."
                                required
                            />
                            <input
                                id="receiver_id"
                                name="receiver_id"
                                type="hidden"
                                class="form-control"
                                value="{{ $conversation->receiver->_id }}"
                                placeholder="Enter receiver_id ID."
                                required
                            />
                        @elseif (Auth::user()->id == $conversation->receiver->_id)
                            <input
                                id="sender_id"
                                name="sender_id"
                                type="hidden"
                                class="form-control"
                                value="{{ Auth::user()->id }}"
                                placeholder="Enter receiver_id ID."
                                required
                            />
                            <input
                                id="receiver_id"
                                name="receiver_id"
                                type="hidden"
                                class="form-control"
                                value="{{ $conversation->sender->_id }}"
                                placeholder="Enter sender_id ID."
                                required
                            />
                        @endif
                        <button type="submit" class="btn btn-primary">
                            Reply
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@php

if (empty($conversation)) { $conversation = null; }

@endphp

<script type="text/javascript">

    var read = "{{ $conversation }}";
    var json = read.replace(/&quot;/g, '"');
    var data = JSON.parse(json);

    console.log("---------- data ----------");
    console.log(data);
    console.log("---------- data ----------");

</script>
@endsection
