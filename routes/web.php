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

Route::get('/test', 'MessageController@test');

Route::group(['as' => 'auth'], function() {
    Route::post('/login', [
        'uses' => 'AuthController@login'
    ]);

    Route::post('/registration', [
        'uses' => 'AuthController@registration'
    ]);

    Route::get('/logout', [
        'uses' => 'AuthController@logout'
    ]);

    Route::get('/check-login', [
        'uses' => 'AuthController@checkLogin'
    ]);
});

Route::group(['as' => 'user'], function() {
    Route::get('/search-friend/{usernameOccurrence}', [
        'uses' => 'UserController@searchByOccurrence'
    ]);

    Route::get('/get-username', [
        'uses' => 'UserController@getUsername'
    ]);

    Route::get('/get-user-id', [
        'uses' => 'UserController@getId'
    ]);
});

Route::group(['as' => 'friends'], function() {
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

Route::group(['as' => 'friendship-requests'], function() {
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

Route::group(['as' => 'groups'], function() {
    Route::get('/get-groups', [
        'uses' => 'GroupController@getPublicTypeAll'
    ]); 

    Route::get('/get-dialog-id/{friendId}', [
        'uses' => 'GroupController@getIdOfDialogType'
    ]);

    Route::post('/create-group', [
        'uses' => 'GroupController@createPublicType'
    ]);

    Route::get('/get-members-of-group/{id}', [
        'uses' => 'GroupController@getMembersOfPublicType'
    ]);

    Route::post('/add-new-members-to-group', [
        'uses' => 'GroupController@addNewMembersToPublicType'
    ]);

    Route::get('/leave-group/{id}', [
        'uses' => 'GroupController@leaveFromPublicType'
    ]);
});

Route::group(['as' => 'messages'], function() {
    Route::get('/get-messages-of-contact/{contactId}', [
        'uses' => 'MessageController@getAllOfContact'
    ]);

    Route::post('/send-message', [
        'uses' => 'MessageController@sendToContact'
    ]);
});

Route::group(['as' => 'unread-message-link'], function() {
    Route::post('/drop-unread-message-link/{contactId}', [
        'uses' => 'UnreadMessageLinkController@drop'
    ]); 
});