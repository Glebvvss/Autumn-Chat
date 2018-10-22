<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Group;
Use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IDialogService as DialogService;

class DialogController extends Controller
{
    private $dialogService;

    public function __construct(DialogService $dialogService)
    {
        $this->dialogService = $dialogService;
    }

    public function getDialogId(Request $request) {
        $dialogId = $this->dialogService->getDialogIdBetween(
            Auth::user()->id, 
            $request->friendId
        );

        return response()->json([
            'dialogId' => $dialogId
        ]);
    }
}