<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Conversation;
use Auth;

use App\Notifications\NewMessage;
use Illuminate\Support\Facades\Notification;

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

        $sent_conversations = $sent_conversations->reverse();

        $received_conversations = Conversation::where('receiver_id','=', Auth::user()->id)->get();

        foreach ($received_conversations as $conversation) {
            $conversation->sender = User::where('_id','=', $conversation->sender_id)->firstOrFail();
            $conversation->receiver = User::where('_id','=', $conversation->receiver_id)->firstOrFail();
        }

        $received_conversations = $received_conversations->reverse();

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
        $conversation->receiver_read = false;
        $conversation->sender_read = false;

        $conversation->save();

        $sender = User::findOrFail(last($conversation->messages)->sender_id);

        $receiver = User::findOrFail(last($conversation->messages)->receiver_id);

        $data = new \stdClass();

        $data->sender = $sender;
        $data->receiver = $receiver;
        $data->conversation = $conversation;

        $receiver->notify(new NewMessage($data));

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

        return redirect()->route('conversation.index');
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
        if (Auth::user()->_id == $conversation->sender_id) {
            $conversation->sender_read = true;
        }
        elseif (Auth::user()->_id == $conversation->receiver_id) {
            $conversation->receiver_read = true;
        }
        $conversation->save();

        $conversation->sender = User::where('_id','=', $conversation->sender_id)->firstOrFail();
        $conversation->receiver = User::where('_id','=', $conversation->receiver_id)->firstOrFail();

        $holder = array();

        // dd($conversation);

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

        // dd($conversation);
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

        // dd($conversation);

        // dd($conversation);
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
        $conversation->receiver_read = false;
        $conversation->sender_read = false;

        // dd($conversation);
        $conversation->save();

        // dd(last($conversation->messages));

        $sender = User::findOrFail(last($conversation->messages)->sender_id);

        $receiver = User::findOrFail(last($conversation->messages)->receiver_id);

        $data = new \stdClass();

        $data->sender = $sender;
        $data->receiver = $receiver;
        $data->conversation = $conversation;

        $receiver->notify(new NewMessage($data));
        // Notification::send($receiver, new NewMessage($data));

        // dd("Customize email! ur getting loads of spam work fast.");

        // dd('check email');

        return redirect()->route('conversation.index');
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

    public function notificationTest(){
        $sender = User::where('email','=', "admin@LBSN.com")->firstOrFail();

        $receiver = User::where('email','=', '4308131@students.swinburne.edu.my')->firstOrFail();

        $data = new \stdClass();

        $data->sender = $sender;
        $data->receiver = $receiver;
        $data->sender = $sender;

        // dd("1");
        $receiver->notify(new NewMessage($data));


        dd("2");
        Notification::send($receiver, new NewMessage($sender));

        dd('check email');

    }
}
