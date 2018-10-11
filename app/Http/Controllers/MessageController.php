<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
Use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $message = new Message();

        $message->text     = $request->text;
        $message->user_id  = Auth::user()->id;
        $message->group_id = $request->groupId;
        $message->save();
    }

    public function getAllOfGroup(Request $request)
    {
        $messages = Message::where('group_id', '=', $request->groupId)
            ->with('user')
            ->get();

        return response()->json([
            'messages' => $messages
        ]);
    }

}
