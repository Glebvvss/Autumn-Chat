<?php

namespace App\Http\Controllers;

use Hash;
use Auth;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;

use App\Services\Realizations\DialogService;

class UserController extends Controller
{
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
        $matchUsernames = User::select('username')
                              ->searchByOccurrence($request->usernameOccurrence)
                              ->get();

        return response()->json([
            'matchUsernames' => $matchUsernames
        ]);
    }
}
