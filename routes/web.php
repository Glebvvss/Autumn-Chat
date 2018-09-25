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
    return view('welcome');
});

Route::group(['as' => 'authenticate'], function() {
	Route::post('/login', 'AuthController@login');	
	Route::post('/registration', 'AuthController@registration');
	Route::get('/logout', 'AuthController@logout');
	Route::get('/check-login', 'AuthController@checkLogin');
  Route::get('/get-username', 'UserController@getUsername');
  Route::get('/get-user-id', 'UserController@getId');
});

Route::group(['as' => 'user'], function() {
  Route::get('/get-user-id', 'UserController@getId');
});

Route::group(['as' => 'friends'], function() {
  Route::get('/get-friends', 'FriendController@getFriends');

  Route::get('/friend-list', 'FriendController@friendList');

  Route::get('/get-friendship-requests', 'FriendController@getFrendshipRequests');
  Route::get('/search-friend/{usernameOccurrence}', 'FriendController@searchFriendByOccurrenceOfUsername');

  Route::get('/send-friendship-request/{recipientUsername}', 'FriendController@sendFriendshipRequest');
  Route::get('/confirm-friendship-request/{senderUsername}', 'FriendController@confirmFriendshipRequest');
  Route::get('/cancel-friendship-request/{senderUsername}', 'FriendController@cancelFriendshipRequest');
});