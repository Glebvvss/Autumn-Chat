<?php

namespace App\Http\Controllers;

use Hash;
use Auth;
use App\Eloquent\User;
use App\Eloquent\Friend;
use Illuminate\Http\Request;
use App\Services\Interfaces\Search\SearchUser;

class UserController extends Controller
{
    private $searchUser;

    public function __construct(SearchUser $searchUser) 
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

    public function test() {
        $user = new User();
        $user->username = 'testuser1';
        $user->email = 'testuser1@example.test';
        $user->password = Hash::make('password');
        $user->save();

        $user = new User();
        $user->username = 'testuser2';
        $user->email = 'testuser2@example.test';
        $user->password = Hash::make('password');
        $user->save();

        $friend = new Friend();
        $friend->user_id = User::where('username', '=', 'testuser1')->first()->id;
        $friend->friend_user_id = User::where('username', '=', 'testuser2')->first()->id;
        $friend->save();

        $friend = new Friend();
        $friend->user_id = User::where('username', '=', 'testuser2')->first()->id;
        $friend->friend_user_id = User::where('username', '=', 'testuser1')->first()->id;
        $friend->save();

        dump(User::all());
    }
}
