<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\Chat;
use App\Models\User;
use App\Models\Group;

use Kreait\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;

class MessageController extends Controller
{
    public function messages(Request $request, $recipient)
    {
        $username = $request->user()->username;
        //$userMessages = User::find($username)->receivedMessages;
        $recipientMessages = User::find($recipient)->receivedMessages()
            ->where('sender', $username);

        //echo $recipientMessages->get();

        $messages = User::find($username)->receivedMessages()
            ->where('sender', $recipient)
            ->union($recipientMessages)
            ->oldest('date_sent')
            ->get();

        return $messages;
    }

    public function groupMessages($groupId)
    {
        $group = Group::find($groupId);
        return $group->messages;
    }

    public function sendToUser(Request $request, $recepient)
    {
        /** Send push notification to device */
        $deviceToken = 'cwn5vX7TA68QopqE8M9N-C:APA91bEc0xCPp0EYk2wasAKQNypRCEXRPSsgGV0JddAIIvHnV85psvmxePL1FAySQF4VE6FTSmpnrgROWihXbe4sAljpDaG9t9jYtqvkNPhQjSeh82nw8j85Osa8zct0OmRhU-r40Yl5';

        $messaging = (new Firebase\Factory())->createMessaging();

        $message = CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => ['title' => 'FCM Message', 'body' => 'This is a message from FCM']
        ]);

        $messaging->send($message);

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

    public function sendToGroup(Request $request, $groupId)
    {
        $group = Group::find($groupId);

        if (!$group->participants->contains($request->user()->username))
            return response('You are not the member of this group', 400);

        $message = Message::create([
            'text' => $request->text,
            'sender' => $request->user()->username,
            'date_sent' => now()
        ]);

        $group->messages()->attach($message->id);
    }
}
