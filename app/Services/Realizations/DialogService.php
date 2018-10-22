<?php

namespace App\Services\Realizations;

use DB;
use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use App\Services\Interfaces\IDialogService;
use Illuminate\Database\Eloquent\Collection;

class DialogService implements IDialogService
{
    public function sendFromTo(int $userId, int $otherUserId, string $text)
    {
        $dialogId = $this->getDialogIdBetween($userId, $otherUserId);

        $message = new Message();
        $message->text = $text;
        $message->user_id = $userId;
        $message->group_id = $dialogId;
        $message->save();
    }

    public function getMessagesBetween(int $userId, int $otherUserId) : Collection
    {
        $dialogId = $this->getDialogIdBetween($userId, $otherUserId);
        $messages = Message::where('group_id', '=', $dialogId)
            ->with('user')
            ->get();

        return $messages;
    }

    public function createBetween(int $userId, int $otherUserId)
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

    public function dropBetween(int $userId, int $otherUserId)
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

    private function deleteAllMessagesOfDialog(int $dialogId)
    {
        Message::where('group_id', '=', $dialogId)->delete();
    }

    private function disociateUsersFromDialog(int $dialogId)
    {
        DB::table('group_user')
            ->where('group_id', '=', $dialogId)
            ->delete();
    }

    private function removeDialogFromDatabase(int $dialogId)
    {
        Group::find($dialogId)->delete();
    }

    public function findDialog(int $userId, int $otherUserId)
    {
        $dialogName = $this->generateDialogName($userId, $otherUserId);

        return Group::where('group_name', '=', $dialogName)
                    ->where('type', '=', 'dialog')
                    ->first();
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

    private function createNewDialog(string $dialogName)
    {
        $group = new Group();
        $group->group_name = $dialogName;
        $group->type = 'dialog';
        $group->save();

        return $group->id;
    }

    private function associateUsersWithDialog(
        int $groupId, 
        int $userId, 
        int $otherUserId
    ){
        $user = User::find($userId);
        $group = Group::find($groupId);
        $group->users()->attach($user);
        $group->save();

        $user = User::find($otherUserId);
        $group = Group::find($groupId);
        $group->users()->attach($user);
        $group->save();
    }
}