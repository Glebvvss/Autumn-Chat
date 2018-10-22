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
        'uses' => 'Friends\FriendController@getAll'
    ]);

    Route::get('/get-friends-who-not-in-group/{groupId}', [ 
        'uses' => 'Friends\FriendController@getAllWhoNotInGroup'
    ]);

    Route::get('/get-all-friends-who-not-in-group/{groupId}', [
        'uses' => 'Friends\FriendController@getAllWhoNotInGroup'
    ]);
});

Route::group(['as' => 'dialogs'], function() {
    Route::get('/get-dialog-id/{friendId}', [
        'uses' => 'Friends\DialogController@getDialogId'
    ]);
});

Route::group(['as' => 'friendship-requests'], function() {
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
});

Route::group(['as' => 'groups'], function() {
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

Route::group(['as' => 'chat-messages'], function() {
    Route::get('/get-messages-of-contact/{contactId}', [
        'uses' => 'ChatMessageController@getAll'
    ]);

    Route::post('/send-message', [
        'uses' => 'ChatMessageController@send'
    ]);
});