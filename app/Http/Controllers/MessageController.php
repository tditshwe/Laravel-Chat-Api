<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function messages()
    {
        $users = DB::select('select * from message');
        $messages = Message::Find(1);

        //return view('user.index', ['users' => $users]);
        return ['users' => $messages,
        'name' => $messages->text];
    }
}
