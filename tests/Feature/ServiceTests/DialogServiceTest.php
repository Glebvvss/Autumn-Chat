<?php

namespace Tests\Feature\ServiceTests;

use DB;
use Hash;
use Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Friend;
use App\Models\Group;
use App\Models\FriendshipRequest;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\Realizations\DialogService;
use Tests\Feature\Mocks\Traits\TMockDataForTables;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DialogServiceTest extends TestCase
{
    use RefreshDatabase, TMockDataForTables;

    public function testCreateBetweenSuccess()
    {
        $userFirst = new User();
        $userFirst->username = 'testuser1';
        $userFirst->email = 'testuser1@example.com';
        $userFirst->password = Hash::make('password');
        $userFirstID = $userFirst->save();

        $userSecond = new User();
        $userSecond->username = 'testuser2';
        $userSecond->email = 'testuser2@example.com';
        $userSecond->password = Hash::make('password');
        $userSecondID = $userSecond->save();

        $dialogService = new DialogService();
        $dialogService->createBetween($userFirstID, $userSecondID);

        $dialogName = 'DIALOG_BETWEEN_'.$userFirstID.'_AND_'.$userSecondID;
        $result = Group::where('group_name', '=', $dialogName)->first();

        if ( $result !== null ) {
          $this->assertTrue(true);
        }
        else {
          $this->assertTrue(false); 
        }
    }

    public function testDropBetweenSuccess()
    {
        $userFirst = new User();
        $userFirst->username = 'testuser1';
        $userFirst->email = 'testuser1@example.com';
        $userFirst->password = Hash::make('password');
        $userFirstID = $userFirst->save();

        $userSecond = new User();
        $userSecond->username = 'testuser2';
        $userSecond->email = 'testuser2@example.com';
        $userSecond->password = Hash::make('password');
        $userSecondID = $userSecond->save();

        $dialogService = new DialogService();
        $dialogService->createBetween($userFirstID, $userSecondID);
        $dialogService->dropBetween($userFirstID, $userSecondID);

        $dialogName = 'DIALOG_BETWEEN_'.$userFirstID.'_AND_'.$userSecondID;
        $result = Group::where('group_name', '=', $dialogName)->first();

        $this->assertNull($result);
    }    
}