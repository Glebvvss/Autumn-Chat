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
	Route::get('/check-role-user', 'AuthController@checkRoleUser');
  Route::get('/get-username', 'UserController@getUsername');
  Route::get('/get-user-id', 'UserController@getId');
});

Route::get('/search-friend/{usernameOccurrence}', 'FriendController@searchFriendByOccurrenceOfUsername');
Route::get('/send-friend-for-request/{friendUsername}', 'FriendController@sendAnRequestForFriendship');
Route::get('/friends', 'FriendController@getFriendsList');