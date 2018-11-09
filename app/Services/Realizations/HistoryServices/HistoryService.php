<?php

namespace App\Services\Realizations\HistoryServices;

use Auth;
use App\Models\User;
use App\Models\History;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use App\Services\Interfaces\IHistoryServices\IHistoryService;

class HistoryService implements IHistoryService
{
    protected $countPostsPerLoad = 5;

    public function setCountPostsPerPage(int $newValue) : void {
        $this->historyPostsPerLoad = $newValue;
    }

    public function getCountPostsPerPage() : int {
        return $historyPostsPerLoad;
    }

    public function getStartPointPostId() : int
    {
        $lastPost = History::where('user_id', '=', Auth::user()->id)
                           ->orderBy('created_at', 'desc')
                           ->first();

        return $lastPost->id;
    }

    public function getSingleLoadList(int $loadNumber, int $startPointPostId) : array
    {   
        Paginator::currentPageResolver(function () use ($loadNumber) {
            return $loadNumber;
        });
        
        $page = History::where('user_id', '=', Auth::user()->id)
                       ->where('id', '<=', $startPointPostId)
                       ->orderBy('created_at', 'desc')
                       ->paginate($this->countPostsPerLoad)
                       ->toArray();

        return $page['data'];
    }

    public function getCountPages() : int
    {
        $paginator = History::where('user_id', '=', Auth::user()->id)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->countPostsPerLoad);

        return $paginator->count();
    }

    public function writeHistoryEvent(string $text, int $userId) : void
    {
        $history = new History();

        $history->text = $text;
        $history->new = true;
        $history->user()->associate(User::find($userId));
        $history->save();
    }

    public function checkOnNewByUserId(int $userId) : bool
    {
        $check = History::where('user_id', '=', $userId)
               ->where('new', '=', 1)
               ->get()
               ->toArray();

        if ( $check === [] ) {
            return true;
        }
        return false;
    }

    public function resetNewMarkers() : void
    {
        History::where('user_id', '=', Auth::user()->id)
               ->where('new', '=', 1)
               ->update(['new' => 0]);
    }
}