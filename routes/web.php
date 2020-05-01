<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {

     /*************************
     *     Route for User     *
     *************************/
    Route::get('edit_profile', 'UserController@edit_profile');
    Route::patch('update_profile', 'UserController@update_profile');

    /**
     * Routes of listing friend request
     */
    Route::get('friendRequest', 'UserController@friendRequest');
    Route::get('friendRequest/datatable', 'UserController@friendRequestDatatable');

    /**
     * Routes of listing friend
     */
    Route::get('send_request/{id}', 'UserController@friendRequest');
    Route::get('accept_request/{id}', 'UserController@friendRequestAccept');
    Route::get('cancle_request/{id}', 'UserController@friendRequestCancle');
    Route::get('unfriend_user/{id}', 'UserController@unfriendUser');
    Route::get('friend', 'UserController@friendList');
    Route::get('friend/datatable', 'UserController@friendListDatatable');
    
    Route::get('pending_request', 'UserController@pendingRequest');
    Route::get('pending_request/datatable', 'UserController@pendingRequestDatatable');
    /**
     * Routes of user listing with same skill
     */
    Route::get('sameskill', 'UserController@sameskill');
    Route::get('sameskill/datatable', 'UserController@sameskillDatatable');

    /**
     * Route for admin
     */
    Route::group(['middleware' => 'CheckRole'], function () {

        /**
         * Routes of skill CRUD for admin
         */
        Route::get('skill/datatable', 'SkillController@datatable');
        Route::resource('skill', 'SkillController', ['except' => ['show']]);

        /**
         * Routes of user listing for admin
         */
        Route::get('user', 'UserController@adminUserList');
        Route::get('user/datatable', 'UserController@adminUserDatatable');
    });
});