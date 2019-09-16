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
        return User::create([
            'username' => $request->username,
            'display_name' => $request->display_name,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60)
        ]);
    }

    public function signIn(Request $request)
    {
        /*$userdata = array(
            'username' => 'samsara' ,
            'password' => 'userpass'
        );*/

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials))
        {
            return Auth::user();
        }
        else
            return array('hasError' => true, 'message' => 'Invalid login details');
    }
}
