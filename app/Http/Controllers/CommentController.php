<?php

namespace App\Http\Controllers;

use App\Events\CommentEvent;
use App\Models\Comment;
use App\Models\Post;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|integer',
        ]);
        $comment = new Comment([
            'content' => $request->content,
        ]);

        $post = Post::find($request->post_id);

        $comment->user()->associate($request->user()->id);
        $comment->post()->associate($post);
        $comment->save();

        $comment->user;

        event(new CommentEvent($comment));


        return response()->json([
            'comment' => $comment
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

        $comment = Comment::find($request->id);

        if ($comment->update($data)) {
            return response()->json([
                'message' => 'Successfully updated comment!'
            ], 201);
        }
    }

    public function delete(Request $request)
    {
        $comment = Comment::find($request->id);
        if (isset($comment)) {
            $comment->delete();
            return response()->json([
                'message' => 'Successfully deleted comment!'
            ], 201);
        } else {
            return response()->json([
                'error' => 'comment Missing Create it !'
            ], 400);
        }
    }
}
