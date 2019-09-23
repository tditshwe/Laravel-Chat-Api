<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\Chat;

class MessageController extends Controller
{
    public function messages(Request $request, $repicient)
    {
        $user = $request->user()->username;
        $messages = Message::where();

        //return view('user.index', ['users' => $users]);
        return ['users' => $messages,
        'name' => $messages->text];
    }

    public function sendToUser(Request $request, $recepient)
    {
        $chats = Chat::where([['sender', $request->user()->username],['receiver', $recepient]])
                    ->orWhere([['sender', $recepient],['receiver',$request->user()->username]])
                    ->get();

        $message = Message::create([
            'text' => $request->text,
            'sender' => $request->user()->username,
            'date_sent' => now()
        ]);

        if ($chats->count() == 0)
        {
            Chat::create([
                'sender' => $request->user()->username,
                'receiver' => $recepient,
                'last_message' => $message->id
            ]);
        }
        else
        {
            $chat = $chats->first();

            $chat->last_message = $message->id;
            $chat->save();
        }
    }
}
