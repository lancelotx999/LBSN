<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Conversation;
use Auth;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sent_conversations = Conversation::where('sender_id','=', Auth::user()->id)->get();

        foreach ($sent_conversations as $conversation) {
            $conversation->sender = User::where('_id','=', $conversation->sender_id)->firstOrFail();
            $conversation->receiver = User::where('_id','=', $conversation->receiver_id)->firstOrFail();
        }

        $received_conversations = Conversation::where('receiver_id','=', Auth::user()->id)->get();

        foreach ($received_conversations as $conversation) {
            $conversation->sender = User::where('_id','=', $conversation->sender_id)->firstOrFail();
            $conversation->receiver = User::where('_id','=', $conversation->receiver_id)->firstOrFail();
        }

        return view('conversations.index', compact('sent_conversations', 'received_conversations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('conversations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Logic
        $this->validate($request,
            [
                'email' => 'required',
                'title' => 'required',
                'message' => 'required',
            ]);

        $conversation = new Conversation;


        $sender = User::where('_id','=', Auth::user()->_id)->firstOrFail();
        $receiver = User::where('email','=', $request->email)->firstOrFail();
        $messages = array();

        $message = new \stdClass();
        $message->sender_id = $sender->_id;
        $message->receiver_id = $receiver->_id;
        $message->content = $request->message;

        array_push($messages,$message);

        $conversation->sender_id = $sender->_id;
        $conversation->receiver_id = $receiver->_id;
        $conversation->title = $request->title;
        $conversation->messages = $messages;
        $conversation->read = false;

        $conversation->save();

        //Store code ends here

        $sent_conversations = Conversation::where('sender_id','=', Auth::user()->id)->get();

        foreach ($sent_conversations as $conversation) {
            $conversation->sender = User::where('_id','=', $conversation->sender_id)->firstOrFail();
            $conversation->receiver = User::where('_id','=', $conversation->receiver_id)->firstOrFail();
        }

        $received_conversations = Conversation::where('receiver_id','=', Auth::user()->id)->get();

        foreach ($received_conversations as $conversation) {
            $conversation->sender = User::where('_id','=', $conversation->sender_id)->firstOrFail();
            $conversation->receiver = User::where('_id','=', $conversation->receiver_id)->firstOrFail();
        }

        return view('conversations.index', compact('sent_conversations', 'received_conversations'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conversation = Conversation::findOrFail($id);
        $conversation->sender = User::where('_id','=', $conversation->sender_id)->firstOrFail();
        $conversation->receiver = User::where('_id','=', $conversation->receiver_id)->firstOrFail();

        $holder = array();

        foreach ($conversation->messages as $key) {
            $message = new \stdClass();
            $message->sender_id = $key['sender_id'];
            $message->receiver_id = $key['receiver_id'];
            $message->content = $key['content'];

            $message->sender = User::where('_id','=', $message->sender_id)->firstOrFail();
            $message->receiver = User::where('_id','=', $message->receiver_id)->firstOrFail();

            // dd($message);
            array_push($holder,$message);
        }

        $conversation->messages = $holder;

        // dd($conversation);

        return view('conversations.show', compact('conversation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $conversation = Conversation::findOrFail($id);

        $holder = array();

        foreach ($conversation->messages as $key) {
            $message = new \stdClass();
            $message->sender_id = $key['sender_id'];
            $message->receiver_id = $key['receiver_id'];
            $message->content = $key['content'];

            // dd($message);
            array_push($holder,$message);
        }

        $message = new \stdClass();
        $message->sender_id = $request->sender_id;
        $message->receiver_id = $request->receiver_id;
        $message->content = $request->content;

        array_push($holder,$message);

        $conversation->messages = $holder;

        // dd($conversation);
        $conversation->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
