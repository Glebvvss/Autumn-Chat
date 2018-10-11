<?php 

namespace Tests\Feature\ServiceTests\FriendshipRequestTests\Traits;

use Hash;
use App\Models\User;
use App\Models\Friend;
use App\Models\FriendshipRequest as FriendshipRequestTable;

trait TMockDataForTables
{
    protected function userTableMock()
    {
        $user = new User();
        $user->username = 'testuser1';
        $user->email    = 'testuser1@example.com';
        $user->password = Hash::make('password');
        $user->save();

        $user = new User();
        $user->username = 'testuser2';
        $user->email    = 'testuser2@example.com';
        $user->password = Hash::make('password');
        $user->save();
    }

    protected function friendTableMock()
    {
        if ( !$this->checkRequirementsForFriendTable() ) {
            throw new Exception('Please mock user tables for mocking friend table');
        }

        $friend = new Friend();
        $friend->user_id        = User::where('username', '=', 'testuser1')->first()->id; 
        $friend->friend_user_id = User::where('username', '=', 'testuser2')->first()->id; 
        $friend->save();

        $friend = new Friend();
        $friend->user_id        = User::where('username', '=', 'testuser2')->first()->id;
        $friend->friend_user_id = User::where('username', '=', 'testuser1')->first()->id;
        $friend->save();
    }

    private function checkRequirementsForFriendTable() {
        $testuser1 = User::where('username', '=', 'testuser1')->first();
        $testuser2 = User::where('username', '=', 'testuser2')->first();

        if ( $testuser1 && $testuser2 ) {
            return true;
        }
        return false;
    }
}