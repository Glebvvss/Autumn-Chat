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
use App\Services\Interfaces\IHistoryServices\IHistoryWriterService as HistoryWriterService;

class HistoryController extends Controller 
{
    protected $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function test(HistoryWriterService $historyWriterService)
    {
        $historyWriterService->addNewMembersToGroup(
            [1], 3
        );
    }

    public function getPage(Request $request)
    {
        $historyPage = $this->historyService->getPage($request->pageNumber);

        return response()->json([
            'historyPage' => $historyPage
        ]);
    }
    
    public function checkOnNew()
    {
        $result = $this->historyService->checkOnNewByUserId( Auth::user()->id );

        return response()->json([
            'result' => $result
        ]);
    }

    public function resetNewMarkers()
    {
        $this->historyService->resetNewMarkers(); 
    }
}