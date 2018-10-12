<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
Use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendToGroup(Request $request)
    {
        $message = new Message();

        $message->text     = $request->text;
        $message->user_id  = Auth::user()->id;
        $message->group_id = $request->groupId;
        $message->save();
    }

    public function sendToDialog(Request $request)
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

    public function getAllOfDialog(Request $request)
    {
        $userId      = Auth::user()->id;
        $otherUserId = $request->friendId;

        $dialogName = 'DIALOG_BETWEEN_'.$userId.'_AND_'.$otherUserId;
        $alternativeDialogName = 'DIALOG_BETWEEN_'.$otherUserId.'_AND_'.$userId;

        $dialogId = Group::where('group_name', '=', $dialogName)->first()->id;

        if ( $dialogId ) {

            $messages = Message::where('group_id', '=', $dialogId)
                ->with('user')
                ->get();
                
        } else {

            $dialogId = Group::where('group_name', '=', $alternativeDialogName)->first()->id;

            $messages = Message::where('group_id', '=', $dialogId)
                ->with('user')
                ->get();
        }

        return response()->json([
            'messages' => $messages
        ]);
    }

}
