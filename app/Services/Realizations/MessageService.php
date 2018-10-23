<?php

namespace App\Services\Realizations;

use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use App\Models\UnreadMassageLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Interfaces\IGroupService;

class MessageService implements IGroupService
{
    public function sendTo(int $contactId, string $text)
    {
        $message = new Message();

        $message->text     = $text;
        $message->user_id  = Auth::user()->id;
        $message->group_id = $contactId;
        
        $messageId = $message->save();

        $this->createUnreadMassageLinks($contactId, $messageId);
    }

    private function createUnreadMassageLinks(int $contactId, int $messageId)
    {
        $contactMembers = $this->getMembersOfContact($contactId);

        foreach( $contactMembers as $contactMember ) {
            $unreadMassageLink = new UnreadMassageLink();

            $unreadMassageLink->message_id = $messageId;
            $unreadMassageLink->user_id = $contactMember->id;
            $unreadMassageLink->group_id = $contactId;
            $unreadMassageLink->save()
        }
    }

    private function getMembersOfContact(int $contactId) : Collection
    {
        return Group::find($contactId)->users()->get();
    }

}
