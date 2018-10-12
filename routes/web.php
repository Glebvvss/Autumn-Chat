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
    Route::post('/login', [
        'uses' => 'Auth\AuthController@login'
    ]);

    Route::post('/registration', [
        'uses' => 'Auth\AuthController@registration'
    ]);

    Route::get('/logout', [
        'uses' => 'Auth\AuthController@logout'
    ]);

    Route::get('/check-login', [
        'uses' => 'Auth\AuthController@checkLogin'
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
        'uses' => 'Friends\FriendController@getAll'
    ]);

    Route::get('/get-friends-who-not-in-group/{groupId}', [ 
        'uses' => 'Friends\FriendController@getAllWhoNotInGroup'
    ]);

    Route::get('/get-all-friends-who-not-in-group/{groupId}', [
        'uses' => 'Friends\FriendController@getAllWhoNotInGroup'
    ]);
});

Route::group(['as' => 'friendship-request'], function() {
    Route::get('/get-recived-friendship-requests', [
        'uses' => 'Friends\FriendshipRequestController@getRecivedAll'
    ]);

    Route::get('/get-sended-friendship-requests', [
        'uses' => 'Friends\FriendshipRequestController@getSendedAll'
    ]);

    Route::get('/send-friendship-request/{username}', [
        'uses' => 'Friends\FriendshipRequestController@send'
    ]);

    Route::get('/confirm-friendship-request/{senderId}', [
        'uses' => 'Friends\FriendshipRequestController@confirm'
    ]);

    Route::get('/cancel-recived-friendship-request/{senderId}', [
        'uses' => 'Friends\FriendshipRequestController@cancelRecived'
    ]);

    Route::get('/cancel-sended-friendship-request/{recipientId}', [
        'uses' => 'Friends\FriendshipRequestController@cancelSended'
    ]);

    Route::get('/get-count-new-recived-friendship-requests', [
        'uses' => 'Friends\FriendshipRequestController@getCountNewRecived'
    ]);

    Route::get('/read-new-recived-friendship-requests', [
        'uses' => 'Friends\FriendshipRequestController@readNewRecived'
    ]);

    Route::get('/get-messages-of-group/{groupId}', [
        'uses' => 'Groups\GroupMessageController@getAll'
    ]);

    Route::post('/send-message', [
        'uses' => 'Groups\GroupMessageController@send'
    ]);
});

Route::group(['as' => 'dialog-messages'], function() {
    Route::get('/get-messages-of-dialog/{friendId}', [
        'uses' => 'Friends\DialogMessageController@getAll'
    ]);

    Route::get('/send-message-to-dialog', [
        'uses' => 'Friends\DialogMessageController@send'
    ]);
});

Route::group(['as' => 'groups'], function() {
    Route::get('/get-groups', [
        'uses' => 'Groups\GroupController@getAll'
    ]); 

    Route::post('/create-group', [
        'uses' => 'Groups\GroupController@create'
    ]);

    Route::get('/get-members-of-group/{id}', [
        'uses' => 'Groups\GroupController@getMembersOfGroup'
    ]);

    Route::post('/add-new-members-to-group', [
        'uses' => 'Groups\GroupController@addNewMembersTo'
    ]);

    Route::get('/leave-group/{id}', [
        'uses' => 'Groups\GroupController@leave'
    ]);
});

Route::group(['as' => 'droup-messages'], function() {
    Route::get('/get-messages-of-group/{groupId}', [
        'uses' => 'Groups\GroupMessageController@getAll'
    ]);

    Route::post('/send-message-to-group', [
        'uses' => 'Groups\GroupMessageController@send'
    ]);
});