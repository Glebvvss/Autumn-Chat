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
    protected $historyPostsByPage = 5;

    public function getPage(int $pageNumber) : array
    {   
        Paginator::currentPageResolver(function () use ($pageNumber) {
            return $pageNumber;
        });
        
        $page = History::where('user_id', '=', Auth::user()->id)
                       ->paginate($this->historyPostsByPage)
                       ->toArray();

        return $page['data'];
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