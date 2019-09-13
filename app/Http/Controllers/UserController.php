<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function signUp(Request $request)
    {
        return User::create([
            'username' => $request->username,
            'display_name' => $request->display_name,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60)
        ]);
    }
}
