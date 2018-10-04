<?php

namespace App\Http\Controllers;

use Auth;
use App\Eloquent\User;
use Illuminate\Http\Request;

class FriendController extends Controller 
{
    public function getAll() 
    {
        $friends = User::find(Auth::user()->id)
            ->friends()
            ->get()
            ->toArray();

        return response()->json([
            'friends' => $friends
        ]);
    }
}