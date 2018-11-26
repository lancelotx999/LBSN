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
                <a href="{{ route('conversation.create') }}">Start New Conversation</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">New Conversation</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('conversation.store') }}">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label for="email">
                                Recipient E-mail:
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="text"
                                class="form-control"
                                placeholder="Enter recipient e-mail."
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="title">
                                Title:
                            </label>
                            <input
                                id="title"
                                name="title"
                                type="text"
                                class="form-control"
                                placeholder="Enter message title."
                                required
                            />
                        </div>
                        <div class="form-group">
                            <label for="message">
                                Message:
                            </label>
                            <textarea
                                class="form-control"
                                id="message"
                                name="message"
                                rows="3"
                                placeholder="Enter message content."
                                required
                            ></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
