<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chatList() {
        return 'Your chat list';
    }

    public function chat($id) {
        $users = DB::select('select * from message');
        return $users;
    }
}
