<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
Use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function getAllOfContact(Request $request)
    {
        $messages = Message::where('group_id', '=', $request->contactId)
            ->with('user')
            ->get();

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function sendToContact(Request $request)
    {
        $message = new Message();

        $message->text     = $request->text;
        $message->user_id  = Auth::user()->id;
        $message->group_id = $request->contactId;
        $message->save();
    }

}