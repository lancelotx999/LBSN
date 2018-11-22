@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h6>
                <a href="{{ url('/') }}">Home</a>
                <i class="fas fa-angle-right"></i>
                <a href="{{ route('conversation.index') }}">Messages</a>
            </h6><hr />
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Sent Messages</div>
                <div class="card-body">
                    @if ($sent_conversations->isEmpty())
                        <br />
                        <h1 class="display-4">Hello, it seems empty here!</h1>
                        <p class="lead">Why don't you try to add some stuff?</p>
                        <hr />
                    @endif
                    @foreach ($sent_conversations as $conversation)
                        <li class="list-group-item">
                            <a href="{{ route('conversations.show', $conversation->_id) }}">
                                <h1>Title: {{ $conversation->title }}</h1>
                                <p>To: {{ $conversation->receiver->name }}</p>
                                <p>Latest Message: {{last($conversation->messages)['content']}}</p>
                                @if ($conversation->receiver_read)
                                    <p>{{$conversation->receiver->name}} has read the message.</p>
                                @elseif ($conversation->receiver_read == false)
                                    <p>{{$conversation->receiver->name}} has not read the message.</p>
                                @endif
                                @if ($conversation->sender_read == false)
                                    <p>You have unread messages.</p>
                                @endif

                            </a>
                        </li>
                    @endforeach
                    </br>
                    <p><a href="{{ route('conversation.create') }}">Start New Conversation</a></p>
                </div>
            </div>
        </div>
    </div>
    </br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Received Messages</div>
                <div class="card-body">
                    @if ($received_conversations->isEmpty())
                        <br />
                        <h1 class="display-4">Hello, it seems empty here!</h1>
                        <p class="lead">Why don't you try to add some stuff?</p>
                        <hr />
                    @endif
                    @foreach ($received_conversations as $conversation)
                    <li class="list-group-item">
                        <a href="{{ route('conversations.show', $conversation->_id) }}">
                            <h1>Title: {{ $conversation->title }}</h1>
                            <p>From: {{ $conversation->sender->name }}</p>
                            <p>Latest Message: {{last($conversation->messages)['content']}}</p>
                            @if ($conversation->sender_read)
                                <p>{{$conversation->sender->name}} has read the message.</p>
                            @elseif ($conversation->sender_read == false)
                                <p>{{$conversation->sender->name}} has not read the message.</p>
                            @endif
                            @if ($conversation->receiver_read == false)
                                <p>You have unread messages.</p>
                            @endif
                        </a>
                    </li>
                    @endforeach
                    </br>
                    <p><a href="{{ route('conversation.create') }}">Start New Conversation</a></p>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">

    var properties = {!! json_encode($sent_conversations->toArray()) !!};
    var read = "{{ $sent_conversations }}";
    var json = read.replace(/&quot;/g, '"');
    var data = JSON.parse(json);

    console.log("---------- data ----------");
    console.log(data);
    console.log("---------- data ----------");



</script>
@endsection
