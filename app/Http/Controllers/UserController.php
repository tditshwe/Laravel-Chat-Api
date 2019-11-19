<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function signUp(Request $request)
    {
        if (User::find($request->username))
            return response(Array('message' => 'This username is already taken'), 400);

        return User::create([
            'username' => $request->username,
            'display_name' => $request->display_name,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60)
        ]);
    }

    public function signIn(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials))
        {
            return Auth::user()->makeVisible('api_token');
        }
        else
            return response(Array('message' => 'Invalid login details'), 400);
    }

    public function contactList(Request $request)
    {
        return User::all()->except($request->user()->username);
    }

    public function edit(Request $request)
    {
        $user = User::find($request->user()->username);
        $user->fill(['display_name' => $request->displayName,
                     'status' => $request->status]);
        $user->save();
    }
}
