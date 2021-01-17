<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Events\PostEvent;
use App\Models\Post;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'content' => 'required|string',
        ]);
        $post = new Post([
            'content' => $request->content,
        ]);

        $imageTypes = ['PNG','jpeg','JPEG','jpg','JPG','gif','png','bmp','svg+xml'];

        if ($request->file) {
            $mime =$request->file->getClientOriginalExtension();
            if (in_array($mime, $imageTypes)) {
                $imageName = $post->id . '_image' . time() . '.' . request()->file->getClientOriginalExtension();

                $request->file->storeAs('public/postfiles', $imageName);

                $post->image = $imageName;
            }else{
                $fileName = $post->id . '_file' . time() . '.' . request()->file->getClientOriginalExtension();

                $request->file->storeAs('public/postfiles', $fileName);

                $post->file = $fileName;
            }
        }

        if($request->url){
            $post->url = $request->url;
        }

        $post->user()->associate($request->user()->id);
        $post->save();
        $post->user;
        $post->comments;

        event(new PostEvent($post));

        return response()->json([
            'post' => $post
        ], 201);
    }

    public function getAll()
    {
        return response()->json([
            'posts' => Post::with('user')->with('comments.user')->orderBy('created_at', 'desc')->get()
        ], 201);
    }

    public function getAllUser(Request $request)
    {
        return response()->json([
            'posts' => Post::with('user')->with('comments.user')->orderBy('created_at', 'desc')->where('user_id',$request->user()->id)->get()
        ], 201);
    }



    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $data = [
            "content" => $request->content,
        ];

        $post = Post::find($request->id);

        if ($post->update($data)) {
            return response()->json([
                'message' => 'Successfully updated post!'
            ], 201);
        }
    }

    public function delete(Request $request)
    {
        $post = Post::find($request->id);
        if (isset($post)) {
            $post->delete();
            return response()->json([
                'message' => 'Successfully deleted post!'
            ], 201);
        } else {
            return response()->json([
                'error' => 'Post Missing Create it !'
            ], 400);
        }
    }

    public function getComments(Request $request)
    {
        $post = Post::find($request->post_id);
        if (isset($post)) {
            return response()->json([
                'comments' => $post->comments
            ], 201);
        } else {
            return response()->json([
                'error' => 'Post Missing Create it !'
            ], 400);
        }
    }
}
