<?php

namespace App\Services\Realizations;

use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use App\Models\UnreadMassageLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Interfaces\IMessageService;

class MessageService implements IMessageService
{
    public function getLastOfContact(int $contactId) : Collection
    {
        return Message::where('group_id', '=', $contactId)
                      ->with('user')
                      ->get();
    }

    public function sendTo(int $contactId, string $text) : array
    {
        $message = new Message();

        $message->text     = $text;
        $message->user_id  = Auth::user()->id;
        $message->group_id = $contactId;
        $message->save();

        $this->createUnreadMassageLinks($contactId);

        return $this->getSingleById($message->id);
    }

    private function getSingleById(int $messageId) : array
    {
        return Message::where('messages.id', '=', $messageId)
                      ->with('user')
                      ->first()
                      ->toArray();
    }

    private function createUnreadMassageLinks(int $contactId)
    {
        $contactMembers = $this->getMembersOfContact($contactId);

        foreach( $contactMembers as $contactMember ) {
            if ( $contactMember->id === Auth::user()->id ) {
                continue;
            }

            $unreadMassageLink = new UnreadMassageLink();

            $unreadMassageLink->user_id    = $contactMember->id;
            $unreadMassageLink->group_id   = $contactId;
            $unreadMassageLink->save();
        }
    }

    private function getMembersOfContact(int $contactId) : Collection
    {
        return Group::find($contactId)->users()->get();
    }

}
