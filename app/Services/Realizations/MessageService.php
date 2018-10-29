<?php

namespace App\Services\Realizations;

use Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use App\Models\UnreadMassageLink;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Interfaces\IMessageService;

class MessageService implements IMessageService
{
    protected $countPerPage = 10;

    public function getMoreOld(
        int $contactId, 
        int $numberScrollLoad, 
        int $startPointMessageId ) : array
    {
        Paginator::currentPageResolver(function () use ($numberScrollLoad) {
            return $numberScrollLoad;
        });

        $paginatedMessages = Message::where('group_id', '=', $contactId)
                                    ->where('id', '<', $startPointMessageId)
                                    ->orderBy('id', 'desc')
                                    ->with('user')
                                    ->paginate($this->countPerPage)
                                    ->toArray();
        
        if ( $this->checkOnLastPage($paginatedMessages) ) {
            $allOldMessagesLoaded = true;
        } else {
            $allOldMessagesLoaded = false;
        }

        $messagesOfPage = $paginatedMessages['data'];
        return [
            'messages'             => array_reverse($messagesOfPage),
            'allOldMessagesLoaded' => $allOldMessagesLoaded
        ];
    }

    public function getLatestAll(int $contactId) : Collection
    {
        $countOfContact = $this->getCountOfContact($contactId);
        $countToSkip = $countOfContact - $this->countPerPage;

        return Message::where('group_id', '=', $contactId)
                      ->skip($countToSkip)
                      ->take($this->countPerPage)
                      ->with('user')
                      ->get();
    }

    private function checkOnLastPage(array $paginatedMessages) : bool
    {
        if ( $paginatedMessages['current_page'] === $paginatedMessages['last_page'] ) {
            return true;
        }

        return false;
    }

    private function getCountOfContactLessId(int $messageId, int $contactId) : int
    {
        return Message::where('group_id', '=', $contactId)
                      ->where('id', '<', $messageId)
                      ->count();
    }

    private function getCountOfContact(int $contactId) : int
    {
        return Message::where('group_id', '=', $contactId)->count();
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

    private function createUnreadMassageLinks(int $contactId) : void
    {
        $contactMembers = $this->getMembers($contactId);

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

    private function getMembers(int $contactId) : Collection
    {
        return Group::find($contactId)->users()->get();
    }

}
