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

    public function getDialogId() {
        $dialogId = $this->dialogService->getDialogIdBetween(
            Auth::user()->id, $friendId
        );

        return response()->json([
            'dialogId' => $dialogId
        ]);
    }

    public function sendToDialogByDialogId(Request $request)
    {
        
    }

    public function sendTo(Request $request)
    {
        $this->dialogService->sendFromTo(
            Auth::user()->id,
            $request->friendId,
            $request->text
        );
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