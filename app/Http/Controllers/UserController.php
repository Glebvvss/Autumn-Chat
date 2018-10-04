<?php

namespace App\Http\Controllers;

use Hash;
use Auth;
use App\Eloquent\User;
use App\Eloquent\Friend;
use Illuminate\Http\Request;
use App\Services\Interfaces\SearchUserService;

class UserController extends Controller
{
    private $searchUser;

    public function __construct(SearchUserService $searchUser) 
    {
        $this->searchUser = $searchUser;
    }

    public function getUsername() 
    {
      return response()->json([
        'username' => Auth::user()->username
      ]);
    }

    public function getId() 
    {
      return response()->json([
        'userId' => Auth::user()->id
      ]);
    }

    public function searchByOccurrence(Request $request) 
    {
        $matchUsernames = $this->searchUser->byOccurrence($request->usernameOccurrence);
        return response()->json([
            'matchUsernames' => $matchUsernames
        ]);
    }
}
