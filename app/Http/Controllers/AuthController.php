<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * User Creation;
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'group_id' => 'required'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $g = Group::find($request->group_id);
        $user->group()->associate($g);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * User login;
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $user->group;

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'userData' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }


    /**
     * User logout;
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * User details;
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     *
     */
    public function getUserPosts(Request $request)
    {
        return response()->json([
            'posts' => $request->user()->posts
        ]);
    }

    public function getUserProfile($id)
    {
        $user = User::find($id);
        $posts = Post::with(['user','comments.user'])->where('user_id',$id)->orderBy('created_at','desc')->get();
        $user->posts = $posts;


        return response()->json([
            'user' => $user
        ]);
    }

    public function getProfs()
    {
        return response()->json([
            'profs' => User::where('role', 1)->get()
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = $request->user();

        $avatarName = $user->id . '_avatar' . time() . '.' . request()->avatar->getClientOriginalExtension();

        $request->avatar->storeAs('public/avatars', $avatarName);

        $user->avatar = $avatarName;

        $user->save();
        // dd($user);

        return response()->json([
            'message' => [
                'updatedAvatar' => ['Successfully changed the profile picture']
            ],
            'user' => $user
        ], 201);
    }


    public function getAvatar(Request $request)
    {
        // return response()->json([
        //     'avatar' => Storage::get('avatars/'.$request->user()->avatar)
        // ]);

        return Storage::get('avatars/' . $request->user()->avatar);
        // return storage_path().'/avatars/'.$request->user()->avatar;
    }
}
