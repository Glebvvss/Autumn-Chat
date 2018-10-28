<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\IUnreadMessageLinkService as UnreadMessageLinkService;

class UnreadMessageLinkController
{
    protected $unreadMessageLinkService;

    public function __construct(UnreadMessageLinkService $unreadMessageLinkService)
    {
        $this->unreadMessageLinkService = $unreadMessageLinkService;
    }

    public function drop(Request $request)
    {
        $this->unreadMessageLinkService->drop($request->contactId);
    }
}