<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Gets */

Route::middleware('auth:api')->get('/chat', 'ChatController@chatList');
Route::middleware('auth:api')->get('/message/{recepient}', 'MessageController@messages');
Route::middleware('auth:api')->get('/user/contacts', 'UserController@contactList');
Route::middleware('auth:api')->get('/group', 'GroupController@get');
Route::middleware('auth:api')->get('/group/{groupId}', 'GroupController@participants');
Route::middleware('auth:api')->get('/message/groups/{groupId}', 'MessageController@groupMessages');

/* Posts */

Route::post('/user/register', 'UserController@signUp');
Route::post('/user/signin', 'UserController@signIn');
Route::middleware('auth:api')->post('/message/{recepient}', 'MessageController@sendToUser');
Route::middleware('auth:api')->post('/message/group/{groupId}', 'MessageController@sendToGroup');
Route::middleware('auth:api')->post('/group/create/{name}', 'GroupController@create');
Route::middleware('auth:api')->post('/group', 'GroupController@addParticipant');

