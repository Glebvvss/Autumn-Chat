<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
Use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\AddNewMessageToList;
use App\Http\Controllers\Controller;
use App\Events\UpdateUnreadMessageMarkers;
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

    public function getMoreOldOfContact(Request $request)
    {
        $messages = $this->messageService->getMoreOld(
            $request->contactId,
            $request->numberScrollLoad,
            $request->startPointMessageId
        );

        if ( $messages === null ) {
            return response()->json([
                'messages' => 'none'
            ]);
        }

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function getLatestAllOfContact(Request $request)
    {
        $messages = $this->messageService->getLatestAll(
            $request->contactId
        );

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function sendToContact(Request $request)
    {
        $message = $this->messageService->sendTo(
            $request->contactId, 
            $request->text
        );

        event( new AddNewMessageToList($request->contactId, $message) );

        $memberIdList = $this->baseGroupService->getMembersIdWithoutSender(
            $request->contactId
        );

        event( new UpdateUnreadMessageMarkers($memberIdList) );
    }

}