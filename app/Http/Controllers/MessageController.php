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

    public function getAllOfContact(Request $request)
    {
        $messages = $this->messageService->getAllOfContact(
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

    public function test()
    {
        $userIdList = $this->baseGroupService->getMembersIdWithoutSender(2);
        dump($userIdList);
        //event( new UpdateUnreadMessageMarkers([1, 2, 3, 4]) );
    }

}