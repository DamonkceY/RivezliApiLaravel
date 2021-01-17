<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request){
        $msg = new Message([
            'content' => $request->content,
        ]);


        $msg->user()->associate($request->user()->id);
        $msg->group()->associate($request->group_id);
        $msg->save();

        $msg->user;

        event(new MessageEvent($request->user(),$request->content));

        return response()->json([
            'message' => $msg
        ], 201);

    }

    public function getGroupMessages(Request $request){
        $msgs = Message::where('group_id',$request->id)->with('user')->get();
        return response()->json([
            'messages' => $msgs
            // 'messages' =>
        ], 201);
    }
}
