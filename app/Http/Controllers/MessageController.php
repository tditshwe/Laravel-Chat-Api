<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\Chat;
use App\Models\User;

class MessageController extends Controller
{
    public function messages(Request $request, $recipient)
    {
        $username = $request->user()->username;
        //$userMessages = User::find($username)->receivedMessages;
        $recipientMessages = User::find($recipient)->receivedMessages();

        $messages = User::find($username)->receivedMessages()
            ->union($recipientMessages)
            ->oldest('date_sent')
            ->get();

        return $messages;
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

        $user = User::find($recepient);
        $user->receivedMessages()->attach($message->id);

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
