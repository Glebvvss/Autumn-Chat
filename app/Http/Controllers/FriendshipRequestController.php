<?php

namespace App\Http\Controllers;

use Auth;
use App\Eloquent\User;
use Illuminate\Http\Request;
use App\Events\UpdateFriendList;
use App\Events\UpdateFriendRequestList;
use App\Services\Interfaces\Contacts\Friends\FriendshipRequest;

class FriendshipRequestController extends Controller 
{
    protected $friendshipRequest;

    public function __construct (FriendshipRequest $friendshipRequest) {
        $this->friendshipRequest = $friendshipRequest;
    }

    public function getRecivedAll() 
    {
        $friendshipRequests = $this->friendshipRequest->getRecivedAll();
        return response()->json([
            'friendshipRequests' => $friendshipRequests
        ]);
    }

    public function getSendedAll() 
    {
        $friendshipRequests = $this->friendshipRequest->getSendedAll();
        return response()->json([
            'friendshipRequests' => $friendshipRequests
        ]);
    }

    public function send(Request $request)
    {
        $result = $this->friendshipRequest->sendTo($request->username);
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
        $result = $this->friendshipRequest->confirmFrom($request->senderId);
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
        $result = $this->friendshipRequest->cancelRecivedFrom($request->senderId);
        if ( $result === 'Friendship request canceled.' ) {
            event( new UpdateFriendRequestList($request->senderId, 'sended') );
        }

        return response()->json([
            'message' => $result
        ]);
    }

    public function cancelSended(Request $request)
    {
        $result = $this->friendshipRequest->cancelSendedTo($request->recipientId);
        if ( $result === 'Friendship request canceled.' ) {
            event( new UpdateFriendRequestList($request->recipientId, 'recived') );
        }

        return response()->json([
            'message' => $result
        ]);
    }

    public function getCountNewRecived() 
    {
        $count = $this->friendshipRequest->countNewRecived();

        return response()->json([
            'count' => $count
        ]);
    }

    public function readNewRecived()
    {
        $this->friendshipRequest->readByRecipient();
    }    

}