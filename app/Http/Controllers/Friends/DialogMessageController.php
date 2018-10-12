<?php

namespace App\Http\Controllers\Friends;

use Auth;
use App\Models\Group;
Use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IDialogService as DialogService;

class DialogMessageController extends Controller
{
    private $dialogService;

    public function __construct(DialogService $dialogService)
    {
        $this->dialogService = $dialogService;
    }

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
        $messages = $this->dialogService->getMessagesBetween(
            Auth::user()->id, 
            $request->friendId
        );

        return response()->json([
            'messages' => $messages
        ]);
    }

}