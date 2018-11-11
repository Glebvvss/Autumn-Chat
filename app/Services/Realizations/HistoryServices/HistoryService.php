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
    protected $postsPerLoad = 5;

    public function setPostsPerLoad(int $newValue) : void {
        $this->postsPerLoad = $newValue;
    }

    public function getPostsPerLoad() : int {
        return $$this->postsPerLoad;
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
                       ->paginate($this->postsPerLoad)
                       ->toArray();

        return $page['data'];
    }

    public function getCountPages() : int
    {
        $paginator = History::where('user_id', '=', Auth::user()->id)
                            ->orderBy('created_at', 'desc')
                            ->paginate($this->postsPerLoad);

        return $paginator->count();
    }

    public function writeHistoryPost(string $text, int $userId)
    {
        $history = new History();

        $history->text = $text;
        $history->new = true;
        $history->user()->associate(User::find($userId));

        $postAddedToBatabese = $history->save();

        if ( !$postAddedToBatabese ) {
            throw new \Exception('Post was not added to database.');
        }

        return $history;
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