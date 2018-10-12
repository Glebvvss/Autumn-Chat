<?php

namespace App\Http\Controllers\Friends;

use Auth;
use App\Models\Group;
Use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DialogMessageController extends Controller
{
    public function send(Request $request)
    {
        $message = new Message();

        $message->text     = $request->text;
        $message->user_id  = Auth::user()->id;
        $message->group_id = $request->groupId;
        $message->save();
    }

    public function getAll(Request $request)
    {

    }

}
