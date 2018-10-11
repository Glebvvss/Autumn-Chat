<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});

Route::group(['as' => 'auth'], function() {
    Route::post('/login', 'AuthController@login');

    Route::post('/registration', 'AuthController@registration');

    Route::get('/logout', 'AuthController@logout');

    Route::get('/check-login', 'AuthController@checkLogin');
});

Route::group(['as' => 'user'], function() {
    Route::get('/search-friend/{usernameOccurrence}', [
        'uses' => 'UserController@searchByOccurrence'
    ]);

    Route::get('/get-username', 'UserController@getUsername');

    Route::get('/get-user-id', 'UserController@getId');
});

Route::group(['as' => 'friend'], function() {
    Route::get('/get-friends', [ 
        'uses' => 'FriendController@getAll'
    ]);

    Route::get('/get-friends-who-not-in-group/{groupId}', [ 
        'uses' => 'FriendController@getAllWhoNotInGroup'
    ]);

    Route::get('/get-all-friends-who-not-in-group/{groupId}', [
        'uses' => 'FriendController@getAllWhoNotInGroup'
    ]);
});

Route::group(['as' => 'friendship-request'], function() {
    Route::get('/get-recived-friendship-requests', [
        'uses' => 'FriendshipRequestController@getRecivedAll'
    ]);

    Route::get('/get-sended-friendship-requests', [
        'uses' => 'FriendshipRequestController@getSendedAll'
    ]);

    Route::get('/send-friendship-request/{username}', [
        'uses' => 'FriendshipRequestController@send'
    ]);

    Route::get('/confirm-friendship-request/{senderId}', [
        'uses' => 'FriendshipRequestController@confirm'
    ]);

    Route::get('/cancel-recived-friendship-request/{senderId}', [
        'uses' => 'FriendshipRequestController@cancelRecived'
    ]);

    Route::get('/cancel-sended-friendship-request/{recipientId}', [
        'uses' => 'FriendshipRequestController@cancelSended'
    ]);

    Route::get('/get-count-new-recived-friendship-requests', [
        'uses' => 'FriendshipRequestController@getCountNewRecived'
    ]);

    Route::get('/read-new-recived-friendship-requests', [
        'uses' => 'FriendshipRequestController@readNewRecived'
    ]);
});

Route::group(['as' => 'group'], function() {
    Route::get('/get-groups', [
        'uses' => 'GroupController@getAll'
    ]); 

    Route::post('/create-group', [
        'uses' => 'GroupController@create'
    ]);

    Route::get('/get-members-of-group/{id}', [
        'uses' => 'GroupController@getMembersOfGroup'
    ]);

    Route::post('/add-new-members-to-group', [
        'uses' => 'GroupController@addNewMembersTo'
    ]);

    Route::get('/leave-group/{id}', [
        'uses' => 'GroupController@leave'
    ]);
});

Route::group(['as' => 'message'], function() {
    Route::get('/get-messages-of-group/{groupId}', [
        'uses' => 'MessageController@getAllOfGroup'
    ]);

    //Route::get('/get-dialog-group-id-bu-friend/{griendId}');

    Route::get('/get-messages-of-dialog/{friendId}', [
        'uses' => 'MessageController@getAllOfDialog'
    ]);

    Route::post('/send-message', [
        'uses' => 'MessageController@send'
    ]);
});