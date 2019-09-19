<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    public function chatList(Request $request) {
        $chatList = Chat::with(['chatSender', 'chatReceiver'])->where('sender', $request->username)
                        ->orWhere('receiver', $request->username)
                        ->get();
                        
        return $chatList;
    }

    public function chat($id) {
        $users = DB::select('select * from message');
        return $users;
    }
}
