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
//TODO:can use '/user' for user details

Route::middleware('auth:api')->group(function () {
    Route::get('/posts','PostsController@index')->name('posts');
    Route::post('/save_post','PostsController@store')->name('save_post');
    Route::get('/edit_posts/{id}','PostsController@edit')->name('edit_post');
    Route::put('/update_post/{id}','PostsController@update')->name('update_post');
    Route::delete('/delete_post/{id}','PostsController@destroy')->name('delete_posts');

    Route::post('/vote','VotesController@store')->name('vote');

    Route::get('/messages','MessagesController@index')->name('messages');
    Route::post('/save_message','MessagesController@store')->name('save_message');
    Route::get('/last_read_messages','MessagesController@lastRead')->name('last_read_messages');
    Route::post('/has_read_message','MessagesController@hasRead')->name('has_read_message');

    Route::get('/comments/{id}','CommentsController@index')->name('comments');
    Route::post('/save_comment','CommentsController@store')->name('save_comment');
    Route::get('/edit_comment/{id}','CommentsController@edit')->name('edit_comment');
    Route::put('/update_comment/{id}','CommentsController@update')->name('update_comment');
    Route::delete('/delete_comment/{id}','CommentsController@destroy')->name('delete_comment');

    Route::post('/enrich/{id}','UserProfileController@enrich')->name('enrich_profile');
    Route::get('/history','UserProfileController@historyPosts')->name('history_posts');

    Route::post('/asked/{id}','UserProfileController@asked')->name('asked');
    Route::put('/edit/{id}','UserProfileController@edit')->name('profile_edit');
    Route::get('/num_of_likes','UserProfileController@numOfLikes')->name('num_of_likes');
    Route::get('/num_of_dislikes','UserProfileController@numOfDislikes')->name('num_of_dislikes');

    Route::get('/get_notifications','NotificationsController@getNotifications')->name('get_notifications');
    Route::get('/mark_as_read','NotificationsController@markAsRead')->name('mark_as_read');

});

Route::post('/save-subscription/{id}',function($id, Request $request){
  $user = \App\User::findOrFail($id);
  $user->updatePushSubscription($request->input('endpoint'), $request->input('keys.p256dh'), $request->input('keys.auth'));
  $user->notify(new \App\Notifications\PostNotification("ha","ha"));
  return response()->json([
    'success' => true
  ]);
});
Route::post('/send-notification/{id}', function($id, Request $request){
  $user = \App\User::findOrFail($id);
  $user->notify(new \App\Notifications\PostNotification("ha","ha"));
  return response()->json([
    'success' => true
  ]);
});
