<?php

namespace App\Services\Realizations\HistoryServices;

use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use App\Services\Interfaces\IHistoryServices\IHistoryWriterService;

class HistoryWriterService extends HistoryService implements IHistoryWriterService
{
    public function friendAdded(int $friendId) : void
    {
        $this->writeHistoryEvent(
            'Friend added ' . User::find($friendId)->username,
            Auth::user()->id
        );

        $this->writeHistoryEvent(
            'Friend added ' . Auth::user()->username,
            $friendId
        );
    }

    public function sendedFriendshipRequestCanceled(int $userId) : void
    {
        $this->writeHistoryEvent(
            'You cancel sended friendship request to ' . User::find($userId)->username . '.',
            Auth::user()->id
        );

        $this->writeHistoryEvent(
            Auth::user()->username . 'cancel sended friendship request to you.',
            $userId
        );
    }

    public function reciviedFriendshipRequestCanceled(int $userId) : void
    {
        $this->writeHistoryEvent(
            'You cancel recivied friendship request from ' . User::find($userId)->username . '.',
            Auth::user()->id
        );

        $this->writeHistoryEvent(
            Auth::user()->username . ' cancel recivied friendship request from you.',
            $userId
        );
    }

    public function friendshipRequestSended(int $userId) : void
    {
        $this->writeHistoryEvent(
            'You sended friendship request to ' . User::find($userId)->username . '.',
            Auth::user()->id
        );

        $this->writeHistoryEvent(
            'You recivied friendship request from ' . Auth::user()->username . '.',
            User::find($userId)->id
        );
    }

    public function groupCreatedBy(int $userCreatorId, int $groupId) : void
    {
        $group   = Group::find($groupId);
        $creator = User::find($userCreatorId);

        $members = Group::find($groupId)
                           ->users()
                           ->get();

        foreach( $members as $member ) {
            if ( $member->id == $creator->id ) {
                $this->writeHistoryEvent(
                    'You created public group named ' . $group->group_name . '.',
                    $creator->id
                );

                continue;
            }

            $this->writeHistoryEvent(
                'You are member of ' . $group->group_name . ' public group, which created by ' . $creator->username,
                $member->id
            );
        }
    }

    public function leaveFromGroup(int $userId, int $groupId) : void
    {
        $group   = Group::find($groupId);
        $leaveUser = User::find($userId);

        $members = Group::find($groupId)
                           ->users()
                           ->get();

        foreach( $members as $member ) {
            if ( $member->id == $leaveUser->id ) {
                $this->writeHistoryEvent(
                    'You leave public group named ' . $group->group_name . '.',
                    $leaveUser->id
                );

                continue;
            }

            $this->writeHistoryEvent(
                $leaveUser->username . ' leave group named ' . $group->group_name . '.',
                $member->id
            );
        }
    }

    public function addNewMembersToGroup(array $newMemberIdList, int $groupId) : void
    {
        $members = Group::find($groupId)
                           ->users()
                           ->get();

        $usernames = $this->generateStringifyUsernameList($newMemberIdList);

        $group = Group::find($groupId);

        foreach( $members as $member ) {
            if ( in_array( $member->id, $newMemberIdList ) ) {
                $this->writeHistoryEvent(
                    'You added to group named ' . $group->group_name . '.',
                    $member->id
                );
            } else {
                $this->writeHistoryEvent(
                    $usernames . ' join to group named ' . $group->group_name . '.',
                    $member->id
                );
            }
        }
    }

    private function generateStringifyUsernameList(array $userIdList) : string
    {
        $users = $this->getUserModelsByIdList($userIdList);

        $usernames = [];
        foreach($users as $user) {
            $usernames[] = $user->username;
        }

        return implode(',', $usernames);
    }

    private function getUserModelsByIdList(array $userIdList)
    {
        $query = User::select('id', 'username');

        foreach($userIdList as $userId) {
            $query->orWhere('id', '=', $userId);
        }
        
        return $query->get();
    }
}