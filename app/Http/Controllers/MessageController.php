<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
Use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IMessageService as MessageService;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

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
        $this->messageService->sendTo(
            $request->contactId, 
            $request->text
        );
    }

}