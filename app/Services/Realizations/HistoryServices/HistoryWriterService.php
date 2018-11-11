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
    public function friendAdded(int $friendId) : array
    {
        $historyPost1 = $this->writeHistoryPost(
                            'You have new friend, who named ' . User::find($friendId)->username . '.',
                            Auth::user()->id
                        );

        $historyPost2 = $this->writeHistoryPost(
                            'You have new friend, who named ' . Auth::user()->username . '.',
                            $friendId
                        );

        return [
            $historyPost1->user_id => $historyPost1,
            $historyPost2->user_id => $historyPost2
        ];
    }

    public function sendedFriendshipRequestCanceled(int $userId) : array
    {
        $historyPost1 = $this->writeHistoryPost(
                            'You canceled sent friendship request to ' . User::find($userId)->username . '.',
                            Auth::user()->id
                        );

        $historyPost2 = $this->writeHistoryPost(
                            Auth::user()->username . ' canceled sent friendship request to you.',
                            $userId
                        );

        return [
            $historyPost1->user_id => $historyPost1,
            $historyPost2->user_id => $historyPost2
        ];
    }

    public function reciviedFriendshipRequestCanceled(int $userId) : array
    {
        $historyPost1 = $this->writeHistoryPost(
                            'You canceled the received friendship request from ' . User::find($userId)->username . '.',
                            Auth::user()->id
                        );

        $historyPost2 = $this->writeHistoryPost(
                            Auth::user()->username . ' canceled the received friendship request from you.',
                            $userId
                        );

        return [
            $historyPost1->user_id => $historyPost1,
            $historyPost2->user_id => $historyPost2
        ];
    }

    public function friendshipRequestSended(int $userId) : array
    {
        $historyPost1 = $this->writeHistoryPost(
                            'You sent friendship request to ' . User::find($userId)->username . '.',
                            Auth::user()->id
                        );

        $historyPost2 = $this->writeHistoryPost(
                            'You received friendship request from ' . Auth::user()->username . '.',
                            User::find($userId)->id
                        );

        return [
            $historyPost1->user_id => $historyPost1,
            $historyPost2->user_id => $historyPost2
        ];
    }

    public function deleteFromFriendList(int $friendId) : array
    {
        $historyPost1 = $this->writeHistoryPost(
                            'You deleted a friend named ' . User::find($friendId)->username . ' from your friend list.',
                            Auth::user()->id
                        );

        $historyPost2 = $this->writeHistoryPost(
                            'You have been deleted from friends of ' . Auth::user()->username, 
                            $friendId
                        );

        return [
            $historyPost1->user_id => $historyPost1,
            $historyPost2->user_id => $historyPost2
        ];   
    }

    public function groupCreatedBy(int $userCreatorId, int $groupId) : array
    {
        $group   = Group::find($groupId);

        $creator = User::find($userCreatorId);

        $members = Group::find($groupId)
                        ->users()
                        ->get();

        $historyPostList = [];
        foreach( $members as $member ) {

            if ( $member->id == $creator->id ) {
                $historyPost =  $this->writeHistoryPost(
                                    'You created public group named ' . $group->group_name . '.',
                                    $creator->id
                                );

                $historyPostList[$historyPost->user_id] = $historyPost;
                continue;
            }

            $historyPost =  $this->writeHistoryPost(
                                'You are member of ' . $group->group_name . 
                                ' public group, which created by ' . $creator->username,

                                $member->id
                            );

            $historyPostList[$historyPost->user_id] = $historyPost;
        }

        return $historyPostList;
    }

    public function leaveFromGroup(int $userId, int $groupId) : array
    {
        $group   = Group::find($groupId);
        $leaveUser = User::find($userId);

        $members = Group::find($groupId)
                        ->users()
                        ->get();

        $historyPostList =  [];
        foreach( $members as $member ) {
            if ( $member->id == $leaveUser->id ) {
                $historyPost =  $this->writeHistoryPost(
                                    'You leave from public group named ' . $group->group_name . '.',
                                    $leaveUser->id
                                );

                $historyPostList[$historyPost->user_id] = $historyPost;
                continue;
            }

            $historyPost =  $this->writeHistoryPost(
                                $leaveUser->username . ' left group named ' . $group->group_name . '.',
                                $member->id
                            );

            $historyPostList[$historyPost->user_id] = $historyPost;
        }

        return $historyPostList;
    }

    public function addNewMembersToGroup(array $newMemberIdList, int $groupId) : array
    {
        $members = Group::find($groupId)
                        ->users()
                        ->get();

        $usernames = $this->generateStringifyUsernameList($newMemberIdList);

        $group = Group::find($groupId);

        $historyPostList = [];
        foreach( $members as $member ) {
            if ( in_array( $member->id, $newMemberIdList ) ) {

                $historyPost =   $this->writeHistoryPost(
                                    'You added to group named ' . $group->group_name . '.',
                                    $member->id
                                );

                $historyPostList[$historyPost->user_id] = $historyPost;

            } else {

                $historyPost =   $this->writeHistoryPost(
                                    $usernames . ' joined to group named ' . $group->group_name . '.',
                                    $member->id
                                );

                $historyPostList[$historyPost->user_id] = $historyPost;
            }
        }

        return $historyPostList;
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