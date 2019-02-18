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
  if(Auth::check()){
    return view('/welcome');
  }
    return view('auth.login');
})->name('home');


Auth::routes();

Route::get('/chat', 'HomeController@chat')->name('chat')->middleware('auth');

Route::get('/profile/{id}','UserProfileController@profile')->name('profile')->middleware('auth');
Route::get('/post/{id}','PostsController@show')->name('single_post')->middleware('auth');
