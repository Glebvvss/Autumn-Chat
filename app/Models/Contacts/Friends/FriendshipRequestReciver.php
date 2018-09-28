<?php

namespace App\Models\Contacts\Friends;

use Auth;
use App\Models\Eloquent\User;
use App\Models\Eloquent\Friend;
use Illuminate\Database\Eloquent\Model;
use App\Models\Eloquent\FriendshipRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Interfaces\Recivers\IRequestReciver;

class FriendshipRequestReciver implements IRequestReciver {

    public function getSendedRequests() : Collection {
        $friendshipRequests = FriendshipRequest::with(['userSender' => function($query) {
            $query->select('id', 'username');

        }])->select('id', 'sender_id', 'recipient_id')
           ->where('sender_id', '=', Auth::user()->id)
           ->get();

        return $friendshipRequests;
    }

    public function getRecivedRequests() : Collection {
        $friendshipRequests = FriendshipRequest::with(['userSender' => function($query) {
            $query->select('id', 'username');

        }])->select('id', 'sender_id', 'recipient_id')
           ->where('recipient_id', '=', Auth::user()->id)
           ->get();

        return $friendshipRequests;
    }

}