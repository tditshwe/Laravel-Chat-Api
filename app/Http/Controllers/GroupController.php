<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;

class GroupController extends Controller
{
    public function create(Request $request, $name)
    {
        $user = User::find($request->user()->username);

        $group = Group::create([
            'creator' => $request->user()->username,
            'name' => $name,
        ]);

        $user->groupsJoined()->attach($group->id);
    }

    public function addParticipant(Request $request)
    {
        $user = User::find($request->participant);

        $user->groupsJoined()->attach($request->group_id);
    }
}
