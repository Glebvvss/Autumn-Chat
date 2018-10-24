<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\IUnreadMessageLinkService as UnreadMessageLinkService;

class UnreadMessageLinkController
{
    protected $unreadMessageLinkService;

    public function (UnreadMessageLinkService $unreadMessageLinkService)
    {
        $this->unreadMessageLinkService = $unreadMessageLinkService
    }

    public function create()
    {

    }

    public function drop(Request $request)
    {
        $this->unreadMessageLinkService->drop($request->contactId);
    }
}