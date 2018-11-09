<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\UpdateFriendList;
use App\Models\FriendshipRequest;
use App\Http\Controllers\Controller;
use App\Events\UpdateFriendRequestList;
use App\Services\Interfaces\IHistoryServices\IHistoryService as HistoryService;

class HistoryController extends Controller 
{
    protected $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function getLatestLoadList(Request $request) {
        $historyPosts = $this->historyService->getSingleLoadList(
            1, $request->startPointPostId
        );

        return response()->json([
            'historyPosts' => $historyPosts,
        ]);
    }

    public function getMoreOldLoadList(Request $request)
    {
        $historyPosts = $this->historyService->getSingleLoadList(
            $request->loadNumber,
            $request->startPointPostId
        );

        return response()->json([
            'historyPosts' => $historyPosts
        ]);
    }

    public function getStartPointPostId()
    {
        $startPointPostId = $this->historyService->getStartPointPostId();

        return response()->json([
            'startPointPostId' => $startPointPostId
        ]);
    }

    public function getCountPages()
    {
        $countPages = $this->historyService->getCountPages();

        return response()->json([
            'countPages' => $countPages
        ]);
    }
    
    public function checkOnNewPosts()
    {
        $result = $this->historyService->checkOnNewByUserId( Auth::user()->id );

        return response()->json([
            'result' => $result
        ]);
    }

    public function resetNewMarkersOnPosts()
    {
        $this->historyService->resetNewMarkers(); 
    }
}