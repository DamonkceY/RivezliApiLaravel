<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\ProfGroupRelation;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function createProf(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt("rivezli2020"),
            'role' => 1
        ]);
        $g = Group::find(1);
        $user->group()->associate($g);
        $user->save();

        return response()->json([
            'prof' => $user
        ], 201);
    }

    public function relateProf(Request $request)
    {
        $group = Group::find($request->group_id);
        $prof = User::find($request->prof_id);

        $r = new ProfGroupRelation();

        $r->group()->associate($group);
        $r->user()->associate($prof);
        $r->save();

        $prof = User::where("id",$request->prof_id)->with("groups.group")->first();
        return response()->json([
            'prof' => $prof
        ], 201);
    }
}
