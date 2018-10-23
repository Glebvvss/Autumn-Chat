<?php 

namespace App\Models\Traits\Scopes;

use Auth;

trait TFriendshipRequestScopes {

    public function scopeSended($query)
    {
        return $query->with(['userRecipient' => function($query) 
        {
            $query->select('id', 'username');
        }
        ])->select('id', 'sender_id', 'recipient_id')
          ->where('sender_id', '=', Auth::user()->id);
    }

    public function scopeRecived($query)
    {
        return $query->with(['userSender' => function($query) 
        {
            $query->select('id', 'username');
        }
        ])->select('id', 'sender_id', 'recipient_id')
          ->where('recipient_id', '=', Auth::user()->id);
    }

}