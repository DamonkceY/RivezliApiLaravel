<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function createProf(Request $request){
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

        $user->save();
        return response()->json([
            'message' => 'Successfully created Prof!'
        ], 201);
    }


}
