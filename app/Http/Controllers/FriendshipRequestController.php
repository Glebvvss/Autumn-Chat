<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\UpdateFriendList;
use App\Models\FriendshipRequest;
use App\Http\Controllers\Controller;
use App\Events\UpdateFriendRequestList;
use App\Services\Interfaces\IFriendshipRequestService as FriendshipRequestService;
use App\Services\Interfaces\IGroupServices\IDialogTypeGroupService as DialogTypeGroupService;

class FriendshipRequestController extends Controller 
{
    protected $friendshipRequestService;
    protected $dialogTypeGroupService;

    public function __construct (
        FriendshipRequestService $friendshipRequestService,
        DialogTypeGroupService   $dialogTypeGroupService
    ){
        $this->friendshipRequestService = $friendshipRequestService;
        $this->dialogTypeGroupService = $dialogTypeGroupService;
    }

    public function getRecivedAll() 
    {
        $friendshipRequests = FriendshipRequest::recived()->get();

        return response()->json([
            'friendshipRequests' => $friendshipRequests
        ]);
    }

    public function getSendedAll() 
    {
        $friendshipRequests = FriendshipRequest::sended()->get();
        
        return response()->json([
            'friendshipRequests' => $friendshipRequests
        ]);
    }

    public function send(Request $request)
    {
        $result = $this->friendshipRequestService->sendTo($request->username);

        if ( $result === 'Request has been sent.' ) {
            $recipient = User::where('username', '=', $request->username)->first();
            event( new UpdateFriendRequestList($recipient->id, 'recived') );
            event( new UpdateFriendRequestList(Auth::user()->id, 'sended') );
        }

        return response()->json([
            'message' => $result
        ]);
    }

    public function confirm(Request $request)
    {        
        $result = $this->friendshipRequestService->confirmFrom($request->senderId);

        $this->dialogTypeGroupService->createBetween(
            $request->senderId, 
            Auth::user()->id
        );

        if ( $result === 'Friend added!' ) {
            event( new UpdateFriendRequestList($request->senderId, 'sended') );
            event( new UpdateFriendList( $request->senderId, 'sender' ) );
        }

        return response()->json([
            'message' => $result
        ]);
    }

    public function cancelRecived(Request $request)
    {
        $result = $this->friendshipRequestService->cancelRecivedFrom($request->senderId);

        if ( $result === 'Friendship request canceled.' ) {
            event( new UpdateFriendRequestList($request->senderId, 'sended') );
        }

        return response()->json([
            'message' => $result
        ]);
    }

    public function cancelSended(Request $request)
    {
        $result = $this->friendshipRequestService->cancelSendedTo($request->recipientId);

        if ( $result === 'Friendship request canceled.' ) {
            event( new UpdateFriendRequestList($request->recipientId, 'recived') );
        }

        return response()->json([
            'message' => $result
        ]);
    }

    public function getCountNewRecived() 
    {
        $count = $this->friendshipRequestService->countNewRecived();

        return response()->json([
            'count' => $count
        ]);
    }

    public function readNewRecived()
    {
        $this->friendshipRequestService->readByRecipient();
    }    

}