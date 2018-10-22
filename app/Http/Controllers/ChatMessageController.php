<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
Use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatMessageController extends Controller
{
    public function send(Request $request)
    {
        $message = new Message();

        $message->text     = $request->text;
        $message->user_id  = Auth::user()->id;
        $message->group_id = $request->contactId;
        $message->save();
    }

    public function getAll(Request $request)
    {
        $messages = Message::where('group_id', '=', $request->contactId)
            ->with('user')
            ->get();

        return response()->json([
            'messages' => $messages
        ]);
    }

}