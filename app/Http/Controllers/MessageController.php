<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
Use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\UpdateMessageList;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IMessageService as MessageService;
use App\Services\Interfaces\IGroupServices\IBaseGroupService as BaseGroupService;

class MessageController extends Controller
{
    protected $messageService;
    protected $baseGroupService;

    public function __construct(
        MessageService   $messageService,
        BaseGroupService $baseGroupService
    ){
        $this->messageService   = $messageService;
        $this->baseGroupService = $baseGroupService;
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

        event( new UpdateMessageList($request->contactId) );
    }

    public function test() {
        event( new UpdateMessageList(2) );
    }

}