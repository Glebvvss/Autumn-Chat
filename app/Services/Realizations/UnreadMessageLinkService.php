<?php

namespace App\Services\Realizations;

use Auth;
use App\Models\UnreadMassageLink;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Realizations\GroupServices\DialogTypeGroupService;
use App\Services\Interfaces\IUnreadMessageLinkService;

class UnreadMessageLinkService implements IUnreadMessageLinkService
{
    public function attachAll(array $groups) : array
    {
        $groupsWithUnreadMessageLinks = [];

        foreach( $groups as $group ) {

            if ( $this->getUnreadMessageLink($group['id']) ) {
                $group['unread_message_exists'] = true;
            }
            else {
                $group['unread_message_exists'] = false; 
            }

            $groupsWithUnreadMessageLinks[] = $group;
        }

        return $groupsWithUnreadMessageLinks;
    }

    public function attach(array $group)
    {
        if ( $this->getUnreadMessageLink($group['id']) ) {
            $group['unread_message_exists'] = true;
        } else {
            $group['unread_message_exists'] = false;
        }

        return $group;
    }

    public function attachToFriendListByDialogs(array $friends) : array
    {
        $friendsWithUnreadMessageLinks = [];
        foreach($friends as $friend) {
            $dialogTypeGroupService = new DialogTypeGroupService();

            $dialogId = $dialogTypeGroupService->getDialogIdBetween(
                Auth::user()->id,
                $friend['id']
            );

            if ( $this->getUnreadMessageLink($dialogId) ) {
                $friend['unread_message_exists'] = true;
            } else {
                $friend['unread_message_exists'] = false;
            }

            $friendsWithUnreadMessageLinks[] = $friend;
        }
        return $friendsWithUnreadMessageLinks;
    }

    public function detach(array $group)
    {

    }

    public function create(int $groupId)
    {
        
    }

    public function drop(int $groupId)
    {
        UnreadMassageLink::where('user_id', '=', Auth::user()->id)
                         ->where('group_id', '=', $groupId)
                         ->delete();
    }

    private function getUnreadMessageLink(int $groupId)
    {
        return UnreadMassageLink::where('user_id', '=', Auth::user()->id)
                                ->where('group_id', '=', $groupId)
                                ->first();
    }
}