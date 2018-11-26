@extends('layouts.app')

@php
$sent = 0; $received = 0;

foreach ($sent_conversations as $conversation) {
    if (!$conversation->sender_read) $sent++;
}

foreach ($received_conversations as $conversation) {
    if (!$conversation->receiver_read) $received++;
}
@endphp

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
                <div class="card-header">
                    Messages&nbsp;&#8212;
                    <a href="{{ route('conversation.create') }}">
                        <i class="fas fa-plus-circle fa-fw"></i> Start a new conversation
                    </a>
                </div>
                <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="sent-tab" data-toggle="tab" href="#sent" 
                        role="tab" aria-controls="sent" aria-selected="true">
                            Messages Sent&nbsp;
                            @if ($sent > 0)
                            <span class="badge badge-primary">{{ $sent }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="received-tab" data-toggle="tab" href="#received" 
                        role="tab" aria-controls="received" aria-selected="false">
                            Messages Received&nbsp;
                            @if ($received > 0)
                            <span class="badge badge-primary">{{ $received }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="sent" 
                    role="tabpanel" aria-labelledby="home-tab"><br />
                    @if ($sent_conversations->isEmpty())
                        <h3 class="display-4">Empty!</h3>
                        <p class="lead">No messages have been sent yet.</p>
                        <hr />
                    @endif
                    @foreach ($sent_conversations as $conversation)
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="nounderline" 
                            href="{{ route('conversation.show', $conversation->_id) }}">
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
                        </div>
                    </div>
                    <hr />
                    @endforeach
                    </div>
                    <div class="tab-pane fade" id="received" 
                    role="tabpanel" aria-labelledby="profile-tab"><br />
                    @if ($received_conversations->isEmpty())
                        <h3 class="display-4">Empty!</h3>
                        <p class="lead">No messages have been received yet.</p>
                        <hr />
                    @endif
                    @foreach ($received_conversations as $conversation)
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="nounderline" 
                            href="{{ route('conversation.show', $conversation->_id) }}">
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
                        </div>
                    </div>
                    <hr />
                    @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
