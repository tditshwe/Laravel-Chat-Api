<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Chat;
//use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{   
    public function chatList(Request $request) {
        $username = $request->user()->username;

        $chatList = Chat::with(['chatSender', 'chatReceiver'])->where('sender', $username)
                        ->orWhere('receiver', $username)
                        ->get();
        //Log::info('Showing user profile for user:' . $request->user());       
        return $chatList;
    }

    public function chat($id) {
        $users = DB::select('select * from message');
        return $users;
    }
}
