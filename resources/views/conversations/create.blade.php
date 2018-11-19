@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Start a New Conversation</div>

                    <div class="panel-body">
                        <form method="POST" action="{{ route('conversations.store') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <p>
                                    <label>
                                        Recipient E-mail:
                                        <input
                                            id="email"
                                            name="email"
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter recipient e-mail."
                                            required
                                        />
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        Title:
                                        <input
                                            id="title"
                                            name="title"
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter message title."
                                            required
                                        />
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        Message:
                                    </label>
                                    <textarea
                                        class="form-control"
                                        id="message"
                                        name="message"
                                        rows="3"
                                        placeholder="Enter message."
                                        required
                                        ></textarea>
                                </p>
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
