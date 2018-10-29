<?php

namespace App\Services\Realizations\GroupServices;

use DB;
use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Interfaces\IGroupServices\IDialogTypeGroupService;

class DialogTypeGroupService extends BaseGroupService implements IDialogTypeGroupService
{
    public function createBetween(int $userId, int $otherUserId) : void
    {
        if ( !$userId || !$otherUserId ) {
            throw new \Exception('Not exists user id numbers.');
        }

        if ( !$this->validateDialogOnExists($userId, $otherUserId) ) {
            throw new \Exception('This group already exists.');
        }

        $dialogName = $this->generateDialogName($userId, $otherUserId);
        $dialogId = $this->createNewDialog($dialogName);
        $this->associateUsersWithDialog($dialogId, $userId, $otherUserId);
    }

    public function dropBetween(int $userId, int $otherUserId) : void
    {
        if ( !$userId || !$otherUserId ) {
            throw new \Exception('Not exists user id numbers.');
        }

        $dialogId = $this->getDialogIdBetween($userId, $otherUserId);
        $this->deleteAllMessagesOfDialog($dialogId);
        $this->disociateUsersFromDialog($dialogId);
        $this->removeDialogFromDatabase($dialogId);
    }

    public function getDialogIdBetween(int $userId, int $otherUserId) : int
    {
        $dialog = $this->findDialog($userId, $otherUserId);
        if ( $dialog ) {
            return $dialog->id;
        } 

        $alternativeDialog = $this->findDialog($otherUserId, $userId);
        if ( $alternativeDialog ) {
            return $alternativeDialog->id;
        }

        throw new \Exception('Dialog is not exists.');
    }

    public function findDialog(int $userId, int $otherUserId)
    {
        $dialogName = $this->generateDialogName($userId, $otherUserId);

        return Group::where('group_name', '=', $dialogName)
                    ->where('type', '=', 'dialog')
                    ->first();
    }

    private function deleteAllMessagesOfDialog(int $dialogId) : void
    {
        Message::where('group_id', '=', $dialogId)->delete();
    }

    private function disociateUsersFromDialog(int $dialogId) : void
    {
        DB::table('group_user')
            ->where('group_id', '=', $dialogId)
            ->delete();
    }

    private function removeDialogFromDatabase(int $dialogId) : void
    {
        Group::find($dialogId)->delete();
    }

    private function generateDialogName(int $userId, int $otherUserId) : string
    {
        return 'DIALOG_BETWEEN_'.$userId.'_AND_'.$otherUserId;
    }

    private function validateDialogOnExists(int $userId, int $otherUserId) : bool
    {
        $dialogName = 'DIALOG_BETWEEN_'.$userId.'_AND_'.$otherUserId;
        $alternativeDialogName = 'DIALOG_BETWEEN_'.$otherUserId.'_AND_'.$userId;

        $check = Group::where([
            ['group_name', '=', $dialogName], 
            ['type', '=', 'dialog']
        ])->orWhere([
            ['group_name', '=', $alternativeDialogName],
            ['type', '=', 'dialog']
        ])->first();

        if ( $check ) {
            return false;
        }
        return true;
    }

    private function createNewDialog(string $dialogName) : int
    {
        $group = new Group();
        $group->group_name = $dialogName;
        $group->type = 'dialog';
        $group->save();

        return $group->id;
    }

    private function associateUsersWithDialog(int $groupId, int $userId, int $otherUserId) : void
    {
        $user  = User::find($userId);
        $group = Group::find($groupId);
        $group->users()->attach($user);
        $group->save();

        $user  = User::find($otherUserId);
        $group = Group::find($groupId);
        $group->users()->attach($user);
        $group->save();
    }
}