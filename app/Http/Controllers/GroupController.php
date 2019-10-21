<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;

class GroupController extends Controller
{
    public function get(Request $request)
    {
        $user = User::find($request->user()->username);

        return $user->groupsJoined;
    }

    public function participants(Request $request, $groupId)
    {
        $group = Group::find($groupId);

        if (!$group->participants->contains($request->user()->username))
            return response('You are not the member of this group', 400);

        return $group->participants;
    }

    public function create(Request $request, $name)
    {
        $user = User::find($request->user()->username);

        $group = Group::create([
            'creator' => $request->user()->username,
            'name' => $name,
        ]);

        $user->groupsJoined()->attach($group->id);

        foreach ($request->participants as $par)
        {
            $par->groupsJoined()->attach($group->id);
        }
    }

    public function addParticipant(Request $request)
    {
        $group = Group::find($request->group_id);

        if ($group->creator != $request->user()->username)
            return response('You need to be the group creator', 400);

        $user = User::find($request->participant);

        if (!$user->groupsJoined->contains($request->group_id))
            $user->groupsJoined()->attach($request->group_id);
    }
}
